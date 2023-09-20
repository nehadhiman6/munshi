<?php

namespace App\Http\Controllers\Matters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matters\FileOpening;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Execution\ExecutionDocument;
use App\Models\Resource\Resource;
use Illuminate\Support\Facades\DB;

class ExecutionDocumentController extends Controller
{
    public function index(Request $request){
    }

    public function store(Request $request){
        $this->validate($request,[
            'file_opening_id' =>'required|exists:file_openings,id',
            'fields.*.field_name'=>'required',
            'document_name'=>'required',
        ]);
        return $this->save($request);
    }


    public function save($request){
        $file_opening = FileOpening::findOrFail($request->file_opening_id);
        $col= new Collection();

        foreach($request->fields as $field){
            $execution_doc = ExecutionDocument::firstOrNew(['file_opening_id'=>$request->file_opening_id,'field_name'=>$field['field_name'],'document_name'=>$request['document_name'],
            'document_no'=>$request->document_no]);
            $execution_doc->fill($field);
            $execution_doc->document_name = $request->document_name;
            $execution_doc->document_no = $request->document_no;
            $col->add($execution_doc);
        }

        $file_opening->executions()->saveMany($col);

        return reply(true,[
            'fields'=>$col
        ]);
    }

    public function saveFiles(Request $request)
    {
        $file_opening = FileOpening::findOrFail($request->file_opening_id);
        $old_detids = $file_opening->execution_docs()->pluck('id')->toArray();


        $execution_docs = new Collection();
        foreach ($request->execution_docs as $execution_doc) {
            if ($execution_doc['attachment_id'] > 0) {
                $res = Resource::firstOrNew(['attachment_id'=>$execution_doc['attachment_id'], 'doc_type' => 'execution_docs', 'resourceable_type' => FileOpening::class, 'resourceable_id' => $request->file_opening_id]);
                $res->attachment_id = $execution_doc['attachment_id'];
                $res->doc_description = $execution_doc['doc_description'];
                $execution_docs->add($res);
            }
        }
        $new_rescources = $execution_docs->pluck('id')->toArray();

        $detach = array_diff($old_detids, $new_rescources);

        DB::beginTransaction();
        $file_opening->execution_docs()->saveMany($execution_docs);
        Resource::whereIn('id', $detach)->delete();
        DB::commit();
        return reply(true);
    }
}
