<?php

namespace App\Http\Controllers\Matters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matters\RequisitionResponse;
use App\Models\Matters\FileOpening;
use Illuminate\Database\Eloquent\Collection;
use DB;
use Gate;


class RequisitionResponseController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('file-openings')) {
            return deny();
        }
        if ($request->ajax()) {
            $count = FileOpening::all()->count();
            $filteredCount = $count;
            $file_openings = FileOpening::orderBy('id','DESC');

            if ($searchStr = $request->input('search.value')) {
                $file_openings = $file_openings->where('', 'like', "%{$searchStr}%");
            }

            $file_openings = $file_openings->take($request->length);
            $filteredCount = $file_openings->count();

            if ($request->start > 0) {
                $file_openings->skip($request->start - 1);
            }

            $file_openings = $file_openings->select()->distinct()->get();
            $file_openings->load([]);
            return [
                'draw' => intval($request->draw),
                'start'=>$request->start,
                'data' => $file_openings,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
        }

        return view('matters.file_opeing_file',compact('file_opening'));
    }

    public function save($request)
    {
        $this->validate($request,[
            'requisition_responses.*.date'=>'required|date_format:m-d-Y',
            'requisition_responses.*.received_date'=>'required|date_format:m-d-Y',
        ]);

        $file_opening = FileOpening::FindOrNew($request->file_opening_id);
        $old_requisition_responses = $file_opening->requisition_responses()->pluck('id')->toArray();


        $requisition_responses = new Collection();


        foreach($request->requisition_responses as $requisition_response){
            $requisition_res = RequisitionResponse::findOrNew($requisition_response['id']);
            $requisition_res->fill($requisition_response);
            $requisition_responses->add($requisition_res);
        }

        $new_response = $requisition_responses->pluck('id')->toArray();
        $detach = array_diff($old_requisition_responses, $new_response);


        DB::beginTransaction();
            $file_opening->requisition_responses()->saveMany($requisition_responses);
            RequisitionResponse::whereIn('id', $detach)->delete();
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
