<?php

namespace App\Http\Controllers\Matters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matters\StatementAdjustment;
use App\Models\Matters\StatementAdjustmentDetail;
use App\Models\Matters\FileOpening;
use DB;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Resource\Resource;

class StatementAdjustmentController extends Controller
{
    public function store(Request $request){
        $this->validate($request,[
            'statement_adjustment.file_opening_id' => 'required|integer',
            'statement_adjustment.sale_price' =>'required',
            'statement_adjustment_details.*.to_date' =>'required|date_format:m-d-Y',
            'statement_adjustment_details.*.from_date' =>'required|date_format:m-d-Y',
            'statement_adjustment_details.*.additional_credit_to'=>'nullable|in:seller,purchaser',
        ],
        [
            'statement_adjustment_details.*.to_date.date_format' =>'to date format is not correct. It should be MM-DD-YYYY',
            'statement_adjustment_details.*.from_date.date_format' =>'from date format is not correct. It should be MM-DD-YYYY',
            'statement_adjustment_details.*.additional_credit_to.in'=>'Invalid type of credit',
        ]);

        return $this->save($request);

    }

    public function save($request){
        $statement_adjustment = StatementAdjustment::firstOrNew(['file_opening_id'=> $request->file_opening_id]);
        $statement_adjustment->fill($request->statement_adjustment);
        $old_detids = $statement_adjustment->resources()->pluck('id')->toArray();

        $file_opening = FileOpening::findOrFail($request['file_opening_id']);
        $old_account_statement_ids = $file_opening->statement_adjustment_details()->pluck('id')->toArray();

        $statements = new Collection();

        foreach($request->statement_adjustment_details as $transaction){
            $statement_transaction = StatementAdjustmentDetail::findOrNew($transaction['id']);
            $statement_transaction->fill($transaction);
            $statements->add($statement_transaction);
        }

        $resources = new Collection();
        foreach ($request->resources as $resource) {
            if ($resource['attachment_id'] > 0) {
                $res = Resource::firstOrNew(['attachment_id'=>$resource['attachment_id'], 'doc_type' => $resource['doc_type'], 'resourceable_type' => StatementAdjustment::class, 'resourceable_id' => $statement_adjustment->id]);
                $res->attachment_id = $resource['attachment_id'];
                $res->doc_description = $resource['doc_description'];
                $resources->add($res);
            }
        }
        $new_rescources = $resources->pluck('id')->toArray();

        $new_ids = $statements->pluck('id')->toArray();
        $detach = array_diff($old_account_statement_ids,$new_ids);
        $detach_resources = array_diff($old_detids, $new_rescources);

        DB::beginTransaction();
            $statement_adjustment->save();
            $file_opening->statement_adjustment_details()->saveMany($statements);
            StatementAdjustmentDetail::whereIn('id',$detach)->delete();
            $statement_adjustment->resources()->saveMany($resources);
            Resource::whereIn('id', $detach_resources)->delete();
        DB::commit();


        $statement_adjustment->load('resources');
        $statements = $file_opening->statement_adjustment_details;
        return reply(true,[
            'statement_adjustment'=>$statement_adjustment,
            'statement_adjustment_details'=>$statements
        ]);
    }
}
