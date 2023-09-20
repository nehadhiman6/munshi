<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\City;
use App\Models\Masters\CityDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CityDepartmentController extends Controller
{
    public function index(Request $request)
    {
        $city_id = $request->city_id ? $request->city_id : 0;
        $city = Null;
        if ($city_id > 0) {
            $city = City::findOrFail($city_id);
        }
        if (Gate::denies('city-departments-modify')) {
            return deny();
        }

        if ($request->ajax()) {
            $count = CityDepartment::where('city_id', $request->city_id)->count();
            $filteredCount = $count;
            $city_departments = CityDepartment::where('city_id', $request->city_id)->orderBy('id', 'DESC');

            if ($searchStr = $request->input('search.value')) {
                $city_departments = $city_departments->where('department_type', 'like', "%{$searchStr}%");
            }

            $city_departments = $city_departments->take($request->length);
            $filteredCount = $city_departments->count();

            if ($request->start > 0) {
                $city_departments->skip($request->start - 1);
            }

            $city_departments = $city_departments->select()->distinct()->get();
            $city_departments->load(['city']);
            return [
                'draw' => intval($request->draw),
                'start' => $request->start,
                'data' => $city_departments,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
        }
        return view('masters.city_department', compact('city', 'city_id'));
    }

    public function save($request)
    {
        $this->validate($request, [
            'department_name' => 'required',
            'email' => 'nullable|email',
            'city_id' => 'required|exists:cities,id',
            'attention' => 'required',
        ]);
        $city_department = CityDepartment::FindOrNew($request->form_id);
        $city_department->fill($request->all());
        $city_department->save();

        return reply(true, [
            'city_department' => $city_department,
        ]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('city-departments-modify')) {
            return deny();
        }
        return $this->save($request);
    }

    public function edit($id)
    {
        if (Gate::denies('city-departments-modify')) {
            return deny();
        }
        $city_department = CityDepartment::findOrFail($id);
        return reply(true, [
            'city_department' => $city_department
        ]);
    }


    public function show($city_id)
    {
        if (Gate::denies('city-departments-modify')) {
            return deny();
        }
        $city_departments = CityDepartment::where('city_id', $city_id)->get();
        return reply(true, [
            'city_departments' => $city_departments
        ]);
    }



    public function update(Request $request, $id)
    {
        if (Gate::denies('city-departments-modify')) {
            return deny();
        }
        return $this->save($request);
    }

    public function destroy($id)
    {
        $city_department = CityDepartment::findOrFail($id);
        $city_department->delete();
        return reply(true, [
            'city_department' => $city_department
        ]);
    }
}
