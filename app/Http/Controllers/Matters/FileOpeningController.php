<?php

namespace App\Http\Controllers\Matters;

use App\Http\Controllers\Controller;
use App\Jobs\SendRecLedgerData;
use App\Models\Company\Company;
use App\Models\Liesure\Leisure;
use Illuminate\Http\Request;
use App\Models\Matters\FileOpening;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class FileOpeningController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('file-openings')) {
            return deny();
        }
        if ($request->ajax()) {
            $count = FileOpening::all()->count();
            $filteredCount = $count;
            $file_openings = FileOpening::leftJoin('properties', 'properties.file_opening_id', '=', 'file_openings.id')
                ->leftJoin('cities', 'properties.city_id', '=', 'cities.id')
                ->orderBy('file_openings.id', 'DESC');

            if ($searchStr = $request->input('search.value')) {
                $file_openings = $file_openings->where(function ($cond) use ($searchStr) {
                    $cond->where('file_no', 'like', "%{$searchStr}%")
                        ->orWhere('record_no', 'like', "%{$searchStr}%")
                        ->orWhere('client_name', 'like', "%{$searchStr}%")
                        ->orWhere('closed_file_no', 'like', "%{$searchStr}%")
                        ->orWhere(DB::raw("ifnull(properties.street_no,'')"), 'like', "%{$searchStr}%")
                        ->orWhere(DB::raw("ifnull(properties.unit_no,'')"), 'like', "%{$searchStr}%")
                        ->orWhere(DB::raw("ifnull(properties.street_name,'')"), 'like', "%{$searchStr}%")
                        ->orWhere(DB::raw("ifnull(cities.city_name,'')"), 'like', "%{$searchStr}%");
                });
            }

            $file_openings = $file_openings->take($request->length);
            $filteredCount = $file_openings->count();

            if ($request->start > 0) {
                $file_openings->skip($request->start - 1);
            }

            $file_openings = $file_openings->select('file_openings.*')->distinct()->get();
            $file_openings->load(['law_clerk', 'solicitor', 'real_estate_agent']);

            return [
                'draw' => intval($request->draw),
                'start' => $request->start,
                'data' => $file_openings,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
        }
        return view('matters.file_openings');
    }

    public function save($request)
    {
        $rules = [
            'file_no' => 'required|min:1|max:191|unique:file_openings',
            'record_no' => 'nullable|min:1|max:191|unique:file_openings',
            'closing_date' => 'nullable|date_format:m-d-Y',
            'agreement_of_ps_date' => 'nullable|date_format:m-d-Y',
            'requisition_date' => 'nullable|date_format:m-d-Y',
        ];
        if (intval($request->form_id) > 0) {
            $rules['file_no'] = 'required|min:1|max:191|unique:file_openings,file_no,' . $request->form_id;
            $rules['record_no'] = 'required|min:1|max:191|unique:file_openings,record_no,' . $request->form_id;
        }
        $this->validate($request, $rules);
        if (intval($request->form_id) == 0) {
            $file_no = FileOpening::count();
            $file_no++;
            $rate = getFileRate($file_no);
            if ($rate != 0) {
                $hst_rate = getHstRate();
                $hst_amt = round($rate * $hst_rate / 100, 2);
                $comp = Company::first();
                if (Leisure::getBalance() + $rate + $hst_amt > 0) {
                    throw ValidationException::withMessages(['gen_msg' => "Low Funds!"]);
                }
            }
        }
        $file_opening = FileOpening::FindOrNew($request->form_id);
        $file_opening->fill($request->all());
        $file_opening->rate = $rate;
        if (intval($request->form_id) == 0) {
            $ledger = new Leisure();
            $ledger->vcode = 'FO' . $file_opening->id;
            $ledger->file_id = $file_opening->id;
            $ledger->trans_date = getToday('m-d-Y');
            $ledger->particulars = 'Charges against File No.' . $file_opening->file_no;
            $ledger->dr_amount = $rate;
            $ledger->cr_amount = 0;
            $ledger->hst_rate = $hst_rate;
            $ledger->hst_amt = $hst_amt;
            $ledger->organization_id = $comp->organization_id;
        }
        DB::beginTransaction();
        $file_opening->save();
        if (intval($request->form_id) == 0) {
            $ledger->vcode = 'FO' . $file_opening->id;
            $ledger->file_id = $file_opening->id;
            $ledger->save();
        }
        DB::commit();
        dispatch(new SendRecLedgerData());

        return reply(true, [
            'file_opening' => $file_opening,
            'addressable_type' => FileOpening::class
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
        $file_opening->load(['law_clerk', 'solicitor', 'real_estate_agent', 'law_clerk']);
        return reply(true, [
            'file_opening' => $file_opening,
        ]);
    }

    public function show($id)
    {
        if (Gate::denies('file-opening-modify')) {
            return deny();
        }
        $file_opening = FileOpening::findOrFail($id);
        $file_opening->load(['property.city.departments', 'purchasers']);
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
