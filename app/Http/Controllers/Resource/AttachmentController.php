<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use  App\Models\Resource\Attachment;
use Illuminate\Support\Facades\File;

class AttachmentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth'])->except(['show']);
    }

    public function index(Request $request)
    {
        $attachments = Attachment::orderBy('id');
        if ($request->has('filter_by')) {
            $mimes = [];
            if ($request->filter_by == 'images') {
                array_merge($mimes, ['image/jpeg', 'image/png']);
            }
            if ($request->filter_by == 'videos') {
                array_merge($mimes, ['video/quicktimeg']);
            }
            $attachments = $attachments->whereIn('mime_type', $mimes);
        }
        if ($request->has('sort_by')) {
            if ($request->sort_by == 'latest') {
                $attachments = $attachments->orderBy('id', 'desc');
            } else if ($request->sort_by == 'name_asc') {
                $attachments = $attachments->orderBy('file_name', 'asc');
            } else if ($request->sort_by == 'name_desc') {
                $attachments = $attachments->orderBy('file_name', 'desc');
            }
        }
        if ($request->ajax()) {
            $attachments = Attachment::orderBy('id', 'desc')->get();
            return reply(true, [
                'attachments' => $attachments
            ]);
        }
    }

    public function showAttachmentList(Request $request)
    {
        // dd($request->all());
        $attachments = Attachment::orderBy('id', 'desc');
        if (auth()->user()->isAdmin()) {
            $attachments = $attachments->where('created_by', '=', auth()->user()->id);
        }
        if ($request->has('filter_by')) {
            $mimes = [];
            // dd(in_array('images', $request->filter_by));
            if (in_array('images', $request->filter_by)) {
                $mimes = array_merge(['image/jpeg', 'image/png'], $mimes);
            }
            if (in_array('videos', $request->filter_by)) {
                $mimes =  array_merge(['video/quicktime','video/x-flv','video/mp4','application/x-mpegURL','video/MP2T','video/3gpp','video/x-msvideo'], $mimes);
            }
            if (in_array('pdf', $request->filter_by)) {
                $mimes =  array_merge(['application/pdf'], $mimes);
            }

            if (!in_array('all', $request->filter_by)) {
                $attachments = $attachments->whereIn('mime_type', $mimes);
            }
        }
        if ($request->has('sort_by')) {
            if ($request->sort_by == 'latest') {
                // dd("latest");
                $attachments = $attachments->orderBy('id', 'DESC');
            } else if ($request->sort_by == "name_asc") {
                $attachments = $attachments->orderBy('file_name', 'ASC');
            } else if ($request->sort_by == 'name_desc') {
                $attachments = $attachments->orderBy('file_name', 'DESC');
            }
        }
        if($request->has('search_name') && $request['search_name'] !=''){
            $attachments = $attachments->where('file_name', 'like', '%' .$request['search_name'] . '%');
        }
        $image_numbers = $request->page == 1 ? 14 : 5;
        $attachments = $attachments->paginate($image_numbers);

        if ($request->ajax()) {
            return reply(true, [
                'attachments' => $attachments
            ]);
        }
    }


    public function store(Request $request){
        $this->validate($request, [
            'filepond' => 'required|file|max:2048',
            // 'filepond' => 'required|file|max:2048',
        ]);

        $file = $request->file('filepond');
        $attachment = new Attachment();
        if ($file) {
            $attachment->file_ext = $file->getClientOriginalExtension();
            $attachment->file_name = $file->getClientOriginalName();
            $attachment->mime_type = $file->getMimeType();
            DB::beginTransaction();
                $attachment->save();
                $current_year =  date("Y");
                $current_month =  date("F");
                $file->move(storage_path('app/files/'.$current_year.'/'.$current_month), $attachment->id . '.' . $attachment->file_ext);
            DB::commit();
        }
        return reply(true, ['attachment' => $attachment->id]);
    }

    public function show(Request $request, $id)
    {

        $attachment = Attachment::findOrFail($id);
        if ($attachment) {
            $attachment_year = $attachment['created_at']->format('Y');
            $attachment_month =  $attachment['created_at']->format('F');
            $file_path = storage_path() . "/app/files/". $attachment_year.'/'. $attachment_month.'/'. $id . '.' . $attachment->file_ext;
            return response()->file($file_path);
        }
    }

    public function downloadAttachment(Request $request, $id)
    {
        $attachment = Attachment::findOrFail($id);
        if ($attachment) {
            $attachment_year = $attachment['created_at']->format('Y');
            $attachment_month =  $attachment['created_at']->format('F');
            $file_path = storage_path() . "/app/files/". $attachment_year.'/'. $attachment_month.'/'. $id . '.' . $attachment->file_ext;
            return response()->download($file_path);
        }
    }


    public function attachmentThumbnail(Request $request, $id)
    {
        $attachment = Attachment::findOrFail($id);
        $attachment_year = $attachment['created_at']->format('Y');
        $attachment_month =  $attachment['created_at']->format('F');

        $img_types=['image/bmp','image/jpeg','	image/gif','image/png'];
        $pdf_types= ['application/pdf'];
        $videos=["video/quicktime","video/3gpp","video/x-msvideo", "video/x-ms-wmv", "video/mp4"];
        $excel=[" application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application/vnd.openxmlformats-officedocument.spreadsheetml.template"];
        $rar = ['application/x-rar-compressed', 'application/octet-stream','application/x-rar'];
        $zip = ['application/zip', 'application/octet-stream','application/x-zip-compressed','multipart/x-zip'];
        $word = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

        if ($attachment) {
            if (in_array($attachment->mime_type, $img_types)) {
                $file_path = storage_path() . "/app/files/". $attachment_year.'/'. $attachment_month.'/'. $id . '.' . $attachment->file_ext;
                return response()->file($file_path);
            }
            else if(in_array($attachment->mime_type, $pdf_types)){
                $file_path = public_path() . "/images/pdf.png";
                return response()->file($file_path);
            }
            else if (in_array($attachment->mime_type, $videos)) {
                $file_path = public_path() . "/images/videoicon.png";
                return response()->file($file_path);
            }
            else if (in_array($attachment->mime_type, $excel)) {
                $file_path = public_path() . "/images/xlsx.png";
                return response()->file($file_path);
            }
            else if (in_array($attachment->mime_type, $rar)) {
                $file_path = public_path() . "/images/rar.png";
                return response()->file($file_path);
            }
            else if (in_array($attachment->mime_type, $zip)) {
                $file_path = public_path() . "/images/zip.png";
                return response()->file($file_path);
            }
              else if (in_array($attachment->mime_type, $word)) {
                $file_path = public_path() . "/images/word.png";
                return response()->file($file_path);
            }
            else {
                $file_path = public_path() . "/images/other.png";
                return response()->file($file_path);
            }
        }

    }


    public function getFileName(Request $request, $id)
    {
        $name = "";
        $attachment = Attachment::findOrFail($id);
        if ($attachment) {
            $name = $attachment->file_name;
        }
        return reply(true, [
            'name' => $name
        ]);
    }
}

