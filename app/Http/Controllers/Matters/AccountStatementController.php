<?php

namespace App\Http\Controllers\Matters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matters\FileOpening;
use App\Models\Matters\AccountStatement;
use App\Models\Matters\AccountStatementDetail;
use Illuminate\Database\Eloquent\Collection;
use DB;

class AccountStatementController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'account_statement.file_opening_id' => 'required|integer',
        ]);

        return $this->save($request);
    }

    public function save($request)
    {
        $account_statement = AccountStatement::firstOrNew(['file_opening_id'=> $request->file_opening_id]);
        $account_statement->fill($request->account_statement);

        // if (floatval($account_statement->total_fees_disbursement_without_hst) == 0) {
        $account_statement->total_fees_disbursement_without_hst = $account_statement->total_fees_disbursement - $account_statement->total_hst;
        // }
        // $old_detids = $account_statement->resources()->pluck('id')->toArray();

        $file_opening = FileOpening::findOrFail($request['file_opening_id']);
        $old_account_statement_ids = $account_statement->account_statement_details()->pluck('id')->toArray();

        $statements = new Collection();

        foreach ($request->account_statement['account_statement_details'] as $account_statement_det) {
            if (!($account_statement_det['editable'] == false &&  $account_statement_det['amount'] == '')) {
                $account_statement_detail = AccountStatementDetail::findOrNew($account_statement_det['id']);
                $account_statement_detail->fill($account_statement_det);
                $statements->add($account_statement_detail);
            }
        }

        // $resources = new Collection();
        // foreach ($request->resources as $resource) {
        //     if($resource['attachment_id'] > 0) {
        //         $res = Resource::firstOrNew(['attachment_id'=>$resource['attachment_id'], 'doc_type' => $resource['doc_type'],
        //         'resourceable_type' => AccountStatement::class, 'resourceable_id' => $statement_adjustment->id]);
        //         $res->attachment_id = $resource['attachment_id'];
        //         $res->doc_description = $resource['doc_description'];
        //         $resources->add($res);
        //     }
        // }
        // $new_rescources = $resources->pluck('id')->toArray();
        $new_ids = $statements->pluck('id')->toArray();
        $detach = array_diff($old_account_statement_ids, $new_ids);
        // $detach_resources = array_diff($old_detids, $new_rescources);

        DB::beginTransaction();
        $account_statement->save();
        $account_statement->account_statement_details()->saveMany($statements);
        AccountStatementDetail::whereIn('id', $detach)->delete();
        // $statement_adjustment->resources()->saveMany($resources);
        // Resource::whereIn('id', $detach_resources)->delete();
        DB::commit();

        $statements = $account_statement->account_statement_details;
        return reply(true, [
            'account_statement'=>$account_statement,
            'account_statement_details'=>$statements
        ]);
    }
}
