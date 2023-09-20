<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masters\LawFirm;
use App\Models\Address\Address;
use Gate;
use DB;

class LawFirmController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('law-firms-list')) {
            return deny();
        }
        if ($request->ajax()) {
            $count = LawFirm::all()->count();
            $filteredCount = $count;
            $law_firm = LawFirm::orderBy('id', 'DESC');

            if ($searchStr = $request->input('search.value')) {
                $law_firm = $law_firm->where('firm_name', 'like', "%{$searchStr}%");
            }

            $law_firm = $law_firm->take($request->length);
            $filteredCount = $law_firm->count();

            if ($request->start > 0) {
                $law_firm->skip($request->start - 1);
            }

            $law_firm = $law_firm->select()->distinct()->get();
            $law_firm->load([]);
            return [
                'draw' => intval($request->draw),
                'start'=>$request->start,
                'data' => $law_firm,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
        }
        return view('masters.law_firm');
    }

    public function save($request)
    {
        $rules = [
            'firm_name'=>'required|min:1|max:191|unique:law_firms,firm_name,' . $request->form_id,
        ];

        $this->validate($request, $rules);
        $law_firm = LawFirm::FindOrNew($request->form_id);
        $law_firm->fill($request->all());

        $address = Address::firstOrNew(['addressable_type'=>LawFirm::class,'addressable_id'=>$request->form_id]);
        $address->fill($request->address);
        $address->addressable_type =LawFirm::class ;
        $address->addressable_id = $request->form_id;


        DB::beginTransaction();
        $law_firm->save();
        $address->addressable_id = $law_firm->id;
        $address->save();
        DB::commit();

        return reply(true, [
            'law_firm' => $law_firm,
        ]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('law-firms-modify')) {
            return deny();
        }
        return $this->save($request);
    }

    public function edit($id)
    {
        if (Gate::denies('law-firms-modify')) {
            return deny();
        }
        $law_firm = LawFirm::findOrFail($id);
        $law_firm->load('address.city');
        return reply(true, [
            'law_firm' => $law_firm
        ]);
    }


    public function update(Request $request, $id)
    {
        if (Gate::denies('law-firms-modify')) {
            return deny();
        }
        return $this->save($request);
    }



}
