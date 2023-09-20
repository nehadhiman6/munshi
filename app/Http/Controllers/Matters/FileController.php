<?php

namespace App\Http\Controllers\Matters;

use App\Http\Controllers\Controller;
use App\Models\Company\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Matters\FileOpening;
use App\Models\Masters\TransactionType;

class FileController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('file-openings')) {
            return deny();
        }
        $file_opening_id = $request->file_opening_id ?  $request->file_opening_id : 0;
        return view('matters.file_page', compact('file_opening_id'));
    }

    public function show($id)
    {
        if (Gate::denies('file-openings')) {
            return deny();
        }
        $file_opening = FileOpening::findOrFail($id);
        $credit_types_for_account_statement = TransactionType::all();
        $file_opening->load([
            'solicitor', 'real_estate_agent', 'sellers.closing_address.city', 'sellers.current_address.city', 'sellers.seller_ids.resources', 'purchasers',
            'purchaser_solicitor.law_clerk', 'purchaser_solicitor.law_firm.address', 'purchaser_solicitor.solicitor.address', 'property.pins', 'property.city.departments', 'mortgages.address.city', 'commission.resources.attachment',
            'mortgages.mortgagee', 'mortgages.solicitor', 'mortgages.additional_charges', 'condo_corporation.address.city', 'commission.address.city', 'commission.real_estate_agent', 'commission.brokerage.address.city',
            'statement_adjustment.resources', 'statement_adjustment_details', 'requisition_responses', 'account_statement.account_statement_details', 'trust_ledgers',
            'redirection_funds', 'documents.resource', 'executions', 'execution_docs.attachment'
        ]);
        $company = Company::first();
        $company->load('solicitor.address');
        $file_opening->company = $company;
        if ($file_opening->property && $file_opening->property->city) {
            if (intval($file_opening->property->city->lro_id) == 0) {
                $file_opening->property->city->lro_name = '';
            } else {
                $file_opening->property->city->lro_name = lotNumbers()[array_search($file_opening->property->city->lro_id, array_column(lotNumbers(), 'id'))]['text'];
            }
        }
        return reply(true, [
            'file_opening' => $file_opening,
            'credit_types' => $credit_types_for_account_statement
        ]);
    }

    public function fileRate()
    {
        return reply('OK', [
            "rate" => getFileRate()
        ]);
    }
}
