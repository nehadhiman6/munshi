<?php

namespace App\Http\Controllers\Matters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matters\Mortgage;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Address\Address;
use App\Models\Matters\FileOpening;
use App\Models\Matters\MortgageCharge;
use DB;
use Gate;

class MortgageController extends Controller
{

    public function save($request)
    {
        $this->validate($request,[
            'mortgages.*.instrument_date'=>'nullable|date_format:m-d-Y',
            'mortgages.*.discharged_on'=>'nullable|date_format:m-d-Y',
            'mortgages.*.discharge_date'=>'nullable|date_format:m-d-Y',

        ]);
        $file_opening = FileOpening::FindOrNew($request->file_opening_id);
        $old_mortgages =$file_opening->mortgages()->pluck('id')->toArray();



        $mortgages = new Collection();

        foreach($request->mortgages as $mortgage){
            $mort = Mortgage::findOrNew($mortgage['id']);
            $mort->fill($mortgage);
            $old_charges = $mort->additional_charges()->pluck('id')->toArray();

            $mort_address = Address::firstOrNew(['addressable_id'=> $mortgage['id'],'addressable_type'=>Mortgage::class]);
            $mort_address->fill($mortgage['address']);
            $mort_address->addressable_type = Mortgage::class;
            $mort->address = $mort_address;

            // dd($mortgage['additional_charges'] );
            $additional_charges = new Collection();
            foreach($mortgage['additional_charges'] as $charge){
                if($charge['particulars'] != ''){
                    $mo_charge = MortgageCharge::findOrNew($charge['id']);
                    $mo_charge->fill($charge);
                    $additional_charges->add($mo_charge);
                }
            }

            $new_charge = $additional_charges->pluck('id')->toArray();
            $detach_mort = array_diff($old_charges, $new_charge);

            $mort['additional_charges'] = $additional_charges;
            $mort['detach'] = $detach_mort;
            $mortgages->add($mort);
        }

        $new_mortgages = $mortgages->pluck('id')->toArray();
        $detach = array_diff($old_mortgages, $new_mortgages);

        DB::beginTransaction();

            foreach($mortgages as $mortgage){
                $mort_address = $mortgage['address'];
                unset($mortgage['address']);
                $mort_additional_charges = $mortgage['additional_charges'];
                unset($mortgage['additional_charges']);
                $mort_detch = $mortgage['detach'];
                unset($mortgage['detach']);
                $mortgage->save();
                $mortgage->address()->save($mort_address);
                $mortgage->additional_charges()->saveMany($mort_additional_charges);
                MortgageCharge::whereIn('id', $mort_detch)->delete();
            }

            Mortgage::whereIn('id', $detach)->delete();
            Address::where('addressable_type',Mortgage::class)->whereIn('addressable_id', $detach)->delete();

        DB::commit();

        return reply(true, [
            'file_opening' => $file_opening,
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

