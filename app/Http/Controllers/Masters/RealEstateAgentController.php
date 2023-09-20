<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masters\RealEstateAgent;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Address\Address;
use Gate;
use DB;

class RealEstateAgentController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::denies('real-estate-agent-list')) {
            return deny();
        }
        if ($request->ajax()) {
            $count = RealEstateAgent::all()->count();
            $filteredCount = $count;
            $real_estate_agents = RealEstateAgent::orderBy('id','DESC');

            if ($searchStr = $request->input('search.value')) {
                $real_estate_agents = $real_estate_agents->where('first_name', 'like', "%{$searchStr}%")
                ->orWhere('middle_name', 'like', "%{$searchStr}%")
                ->orWhere('last_name', 'like', "%{$searchStr}%")
                ->orWhere('email', 'like', "%{$searchStr}%");
            }

            $real_estate_agents = $real_estate_agents->take($request->length);
            $filteredCount = $real_estate_agents->count();

            if ($request->start > 0) {
                $real_estate_agents->skip($request->start - 1);
            }

            $real_estate_agents = $real_estate_agents->select()->distinct()->get();
            return [
                'draw' => intval($request->draw),
                'start'=>$request->start,
                'data' => $real_estate_agents,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
        }
        return view('masters.real_estate_agent');
    }

    public function save($request)
    {
        $this->validate($request,[
            'first_name'=>'required|min:1|max:191',
            'is_active'=>'nullable|in:Y,N',
            'email'=>'required|email|unique:real_estate_agents,email,'.$request->form_id,
            'gender'=>'required|in:male,female,other',
        ]);
        $real_estate_agent = RealEstateAgent::findOrNew($request->form_id);
        $real_estate_agent->fill($request->all());

        $address = Address::firstOrNew(['addressable_type'=>RealEstateAgent::class,'addressable_id'=>$request->form_id]);
        $address->fill($request->address);
        $address->addressable_type =RealEstateAgent::class;
        $address->addressable_id = $request->form_id;
        // dd($contact_informations);
        DB::beginTransaction();
            $real_estate_agent->save();
            $address->addressable_id = $real_estate_agent->id;
            $address->save();
        DB::commit();

        return reply(true, [
            'real_estate_agent' => $real_estate_agent,
            'addressable_type'=> RealEstateAgent::class
        ]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('real-estate-agent-modify')) {
            return deny();
        }
        return $this->save($request);
    }

    public function edit($id)
    {
        if (Gate::denies('real-estate-agent-modify')) {
            return deny();
        }
        $real_estate_agent = RealEstateAgent::findOrFail($id);
        $real_estate_agent->load(['address.city']);
        return reply(true, [
            'real_estate_agent' => $real_estate_agent
        ]);
    }


    public function update(Request $request, $id)
    {
        if (Gate::denies('real-estate-agent-modify')) {
            return deny();
        }
        return $this->save($request);
    }

}
