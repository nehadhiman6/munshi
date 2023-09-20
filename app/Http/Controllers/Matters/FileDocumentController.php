<?php

namespace App\Http\Controllers\Matters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matters\FileDocument;
use App\Models\Matters\FileOpening;
use App\Models\Resource\Resource;
use Illuminate\Database\Eloquent\Collection;
use Gate;
use DB;

class FileDocumentController extends Controller
{

    public function save($request)
    {
        $this->validate($request,[
            'documents.*.document_date'=>'required|date_format:m-d-Y',
            'documents.*.doc_type'=>'required|max:191',
            'documents.*.subject'=>'required|max:1000',
            'documents.*.remarks'=>'nullable|max:2000',
        ]);
        $file_opening = FileOpening::FindOrNew($request->file_opening_id);
        $old_documents =$file_opening->documents()->pluck('id')->toArray();

        $documents = new Collection();

        foreach($request->documents as $document){
            $doc = FileDocument::findOrNew($document['id']);
            $doc->fill($document);
            $resource = Resource::firstOrNew(['resourceable_id'=>$document['id'],'resourceable_type'=>FileDocument::class]);
            $resource->fill($document['resource']);
            $resource->resourceable_type = FileDocument::class;
            $resource->resourceable_id = $document['id'];
            $doc['resource'] = $resource;
            $documents->add($doc);
        }

        $new_documents = $documents->pluck('id')->toArray();
        $detach = array_diff($old_documents, $new_documents);

        DB::beginTransaction();
            foreach($documents as $doc){
                $resource = $doc['resource'];
                unset($doc['resource']);
                $doc->file_opening_id = $request->file_opening_id;
                $doc->save();
                $resource->resourceable_id = $doc['id'];
                $resource->save();
            }
            FileDocument::whereIn('id', $detach)->delete();
        DB::commit();

        return reply(true, [
            'file_opening' => $file_opening,
        ]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('file-opening-modify')) {
            return deny();
        }
        return $this->save($request);
    }

    public function edit($id)
    {
        if (Gate::denies('file-opening-modify')) {
            return deny();
        }
        $file_opening = FileOpening::findOrFail($id);
        return reply(true, [
            'file_opening' => $file_opening
        ]);
    }


    public function update(Request $request, $id)
    {
        if (Gate::denies('file-opening-modify')) {
            return deny();
        }
        return $this->save($request);
    }
}

