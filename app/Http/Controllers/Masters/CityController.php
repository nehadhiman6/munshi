<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masters\City;
use Illuminate\Support\Facades\Gate;

class CityController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::denies('cities-list')) {
            return deny();
        }
        if ($request->ajax()) {
            $count = City::all()->count();
            $filteredCount = $count;
            $cities = City::orderBy('id', 'DESC');

            if ($searchStr = $request->input('search.value')) {
                $cities = $cities->where('city_name', 'like', "%{$searchStr}%");
            }

            $cities = $cities->take($request->length);
            $filteredCount = $cities->count();

            if ($request->start > 0) {
                $cities->skip($request->start);
            }

            $cities = $cities->select()->distinct()->get();
            $cities->load([]);
            return [
                'draw' => intval($request->draw),
                'start' => $request->start,
                'data' => $cities,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
        }
        return view('masters.cities');
    }

    public function save($request)
    {
        $this->validate($request, [
            'city_name' => 'required|unique:cities,city_name,' . $request->form_id . ',id,state,' . $request->state,
            'state' => 'required',
            'country' => 'required',
        ]);
        $city = City::FindOrNew($request->form_id);
        $city->fill($request->all());
        $city->save();
        return reply(true, [
            'city' => $city
        ]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('cities-list')) {
            return deny();
        }
        return $this->save($request);
    }

    public function edit($id)
    {
        if (Gate::denies('cities-modify')) {
            return deny();
        }
        $city = City::findOrFail($id);
        return reply(true, [
            'city' => $city
        ]);
    }


    public function update(Request $request, $id)
    {
        if (Gate::denies('cities-modify')) {
            return deny();
        }
        return $this->save($request);
    }
}
