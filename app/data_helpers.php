<?php

use App\Jobs\SendRecLedgerData;
use App\Jobs\UpdateLedger;
use App\Models\Auth\Role;
use  App\Models\Auth\Permission;
use App\Models\Company\Organization;
use App\Models\Liesure\Leisure;
use App\Models\Masters\City;
use App\Models\Matters\FileOpening;
use App\Services\SendDataService;

function getRoles()
{
    return ['' => 'Select'] + Role::orderBy('name')->pluck('name', 'id')->toArray();
}


function getPermissions()
{
    $user = auth()->user();
    if ($user->id == 1) {
        $permission = Permission::get();
    } else {
        $permission = $user->roles->first()->permissions()->get();
    }
    return $permission->pluck('name', 'name')->toArray();
    $permissions = [];
    foreach (Permission::all() as $permission) {
        if ($permission->admin == "Y") {
            $permissions[$permission->name] = true;
        }
    }
    return $permissions;
}


function getDepartmentTypes()
{
    return [
        [
            'name' => 'Water',
            'value' => 'water'
        ],
        [
            'name' => 'Tax',
            'value' => 'tax'
        ],
        [
            'name' => 'Hydro',
            'value' => 'hydro'
        ],
        [
            'name' => 'Gas',
            'value' => 'gas'
        ],
    ];
}


function getCities()
{
    return City::all();
}

function getHstRate()
{
    return 13;
}

function getFileRate($file_no = 0)
{
    // return 10;
    if ($file_no == 0) {
        dispatch(new SendRecLedgerData());
        $file_no = FileOpening::count();
        $file_no++;
    }
    $service = new SendDataService();
    $data = $service->getFileRates([]);
    $rate = 0;
    $data = json_decode($data, true);
    if (array_key_exists('data', $data)) {
        $data = $data['data'];
        $file_qty = 0;
        foreach ($data as $val) {
            if ($file_no > $file_qty && $file_no <= $file_qty + intval($val['no_of_files'])) {
                $rate = $val['rate'];
            }
            $file_qty += intval($val['no_of_files']);
        }
    }
    return $rate;
}

function get_acno()
{
    $org = Organization::get()->first();
    return  $org ? $org->account_no : null;
}

function testing()
{
    return Leisure::getBalance();
    dispatch(new SendRecLedgerData());
    // dispatch(new UpdateLedger(4));
}
