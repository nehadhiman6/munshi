<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masters\Solicitor;
use App\Models\Address\Address;
use Gate;
use DB;

class SolicitorController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('solicitor-list')) {
            return deny();
        }
        if ($request->ajax()) {
            $count = Solicitor::all()->count();
            $filteredCount = $count;
            $solicitor = Solicitor::orderBy('id', 'DESC');

            if ($searchStr = $request->input('search.value')) {
                $solicitor = $solicitor->where('first_name', 'like', "%{$searchStr}%")
                ->orWhere('middle_name', 'like', "%{$searchStr}%")
                ->orWhere('last_name', 'like', "%{$searchStr}%")
                ->orWhere('email', 'like', "%{$searchStr}%");
            }

            $solicitor = $solicitor->take($request->length);
            $filteredCount = $solicitor->count();

            if ($request->start > 0) {
                $solicitor->skip($request->start - 1);
            }

            $solicitor = $solicitor->select()->distinct()->get();
            $solicitor->load([]);
            return [
                'draw' => intval($request->draw),
                'start'=>$request->start,
                'data' => $solicitor,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
        }
        return view('masters.solicitor');
    }

    public function save($request)
    {
        $rules = [
            'first_name'=>'required|min:1|max:191',
            'email'=>'required|email|unique:solicitors,email',
        ];
        if (intval($request->form_id) > 0) {
            $rules['email'] = 'required|email|unique:solicitors,email,' . $request->form_id;
        }
        $this->validate($request, $rules);
        $solicitor = Solicitor::FindOrNew($request->form_id);
        $solicitor->fill($request->all());

        // dd($solicitor);

        $address = Address::firstOrNew(['addressable_type'=>Solicitor::class,'addressable_id'=>$request->form_id]);
        $address->fill($request->address);
        $address->addressable_type =Solicitor::class ;
        $address->addressable_id = $request->form_id;


        DB::beginTransaction();
        $solicitor->save();
        $address->addressable_id = $solicitor->id;
        $address->save();
        DB::commit();

        return reply(true, [
            'solicitor' => $solicitor,
        ]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('solicitor-modify')) {
            return deny();
        }
        return $this->save($request);
    }

    public function edit($id)
    {
        if (Gate::denies('solicitor-modify')) {
            return deny();
        }
        $solicitor = Solicitor::findOrFail($id);
        $solicitor->load(['address.city','law_firm']);
        return reply(true, [
            'solicitor' => $solicitor
        ]);
    }

    public function show($id)
    {
        if (Gate::denies('solicitor-modify')) {
            return deny();
        }
        $solicitor = Solicitor::findOrFail($id);
        $solicitor->load(['address.city','law_firm.address.city']);
        return reply(true, [
            'solicitor' => $solicitor
        ]);
    }


    public function update(Request $request, $id)
    {
        if (Gate::denies('solicitor-modify')) {
            return deny();
        }
        return $this->save($request);
    }



}
