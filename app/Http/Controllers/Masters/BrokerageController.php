<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masters\Brokerage;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Address\Address;
use Gate;
use DB;

class BrokerageController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::denies('brokerage-list')) {
            return deny();
        }
        if ($request->ajax()) {
            $count = Brokerage::all()->count();
            $filteredCount = $count;
            $brokerages = Brokerage::orderBy('id','DESC');

            if ($searchStr = $request->input('search.value')) {
                $brokerages = $brokerages->where('name', 'like', "%{$searchStr}%")
                ->orWhere('email', 'like', "%{$searchStr}%");
            }

            $brokerages = $brokerages->take($request->length);
            $filteredCount = $brokerages->count();

            if ($request->start > 0) {
                $brokerages->skip($request->start - 1);
            }

            $brokerages = $brokerages->select()->distinct()->get();
            return [
                'draw' => intval($request->draw),
                'start'=>$request->start,
                'data' => $brokerages,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
        }
        return view('masters.brokerage');
    }

    public function save($request)
    {
        $this->validate($request,[
            'name'=>'required|min:1|max:191',
            'email'=>'required|email|unique:brokerages,email,'.$request->form_id,
            // 'is_active'=>'nullable|in:Y,N',

        ]);
        $brokerage = Brokerage::findOrNew($request->form_id);
        $brokerage->fill($request->all());

        $address = Address::firstOrNew(['addressable_type'=>Brokerage::class,'addressable_id'=>$request->form_id]);
        $address->fill($request->address);
        $address->addressable_type =Brokerage::class ;
        $address->addressable_id = $request->form_id;
        // dd($contact_informations);
        DB::beginTransaction();
            $brokerage->save();
            $address->addressable_id = $brokerage->id;
            $address->save();
        DB::commit();

        return reply(true, [
            'brokerage' => $brokerage,
            'addressable_type'=> Brokerage::class
        ]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('brokerage-modify')) {
            return deny();
        }
        return $this->save($request);
    }

    public function edit($id)
    {
        if (Gate::denies('brokerage-modify')) {
            return deny();
        }
        $brokerage = Brokerage::findOrFail($id);
        $brokerage->load(['address.city']);
        return reply(true, [
            'brokerage' => $brokerage
        ]);
    }


    public function update(Request $request, $id)
    {
        if (Gate::denies('brokerage-modify')) {
            return deny();
        }
        return $this->save($request);
    }

}
