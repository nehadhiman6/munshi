<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Company\Company;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $company = Company::first();
        if ($company) {
            $company->load('city');
        }
        return reply(true, [
            'company' =>$company
        ]);
    }

    public function store(Request $request)
    {
        $company = Company::findOrNew(1);
        $company->fill($request->all());
        $company->organization_id = 0;
        $company->save();

        return reply(true, [
            'company' =>$company
        ]);
    }
}
