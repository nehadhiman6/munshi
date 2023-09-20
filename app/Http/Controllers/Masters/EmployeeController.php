<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masters\Employee;
use App\Models\Address\Address;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Matters\Mortgage;
use App\Models\Matters\FileOpening;
use App\Models\Matters\SolicitorPurchaser;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('employees-list')) {
            return deny();
        }
        if ($request->ajax()) {
            $count = Employee::all()->count();
            $filteredCount = $count;
            $employees = Employee::orderBy('id', 'DESC');

            if ($searchStr = $request->input('search.value')) {
                $employees = $employees->where('', 'like', "%{$searchStr}%");
            }

            $employees = $employees->take($request->length);
            $filteredCount = $employees->count();

            if ($request->start > 0) {
                $employees->skip($request->start - 1);
            }

            $employees = $employees->select()->distinct()->get();
            $employees->load([]);
            return [
                'draw' => intval($request->draw),
                'start'=>$request->start,
                'data' => $employees,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
        }
        // return view('masters.employees');
        return view('dashboard.dashboard');
    }

    public function save($request)
    {
        $rules = [
            'first_name'=>'required|min:1|max:191',
            'email'=>'required|email|unique:employees,email',
        ];
        if (intval($request->form_id) > 0) {
            $rules['email'] = 'required|email|unique:employees,email,' . $request->form_id;
        }
        $this->validate($request, $rules);
        $employee = Employee::FindOrNew($request->form_id);
        $employee->fill($request->all());

        $address = Address::firstOrNew(['addressable_type'=>Employee::class,'addressable_id'=>$request->form_id]);
        $address->fill($request->address);
        $address->addressable_type =Employee::class ;
        $address->addressable_id = $request->form_id;


        DB::beginTransaction();
        $employee->save();
        $address->addressable_id = $employee->id;
        $address->save();
        DB::commit();

        return reply(true, [
            'employee' => $employee,
        ]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('employees-modify')) {
            return deny();
        }
        return $this->save($request);
    }

    public function edit($id)
    {
        if (Gate::denies('employees-modify')) {
            return deny();
        }
        $employee = Employee::findOrFail($id);
        $employee->load('address.city');
        return reply(true, [
            'employee' => $employee
        ]);
    }


    public function update(Request $request, $id)
    {
        if (Gate::denies('employees-modify')) {
            return deny();
        }
        return $this->save($request);
    }



    public function destroy(Request $request, $id)
    {
        if (Gate::denies('employee-delete')) {
            return deny();
        }

        $deleted =false;
        $employee = Employee::findOrFail($id);

        if ($employee->type == 'solicitor') {
            $mortgage = Mortgage::where('solicitor_id', $id)->first();
            $file_opening = FileOpening::where('solicitor_id', $id)->first();
            $purchase = SolicitorPurchaser::where('solicitor_id', $id)->first();
            if ($mortgage == null && $file_opening == null && $purchase ==null) {
                $employee->delete();
                $deleted= true;
            }
        } elseif ($employee->type == 'law_clerk') {
            $file_opening = FileOpening::where('law_clerk_id', $id)->first();
            $purchase = SolicitorPurchaser::where('law_clerk_id', $id)->first();
            if ($file_opening == null && $purchase ==null) {
                $employee->delete();
                $deleted= true;
            }
        }

        return reply(true, [
            'deleted'=>$deleted
        ]);
    }
}
