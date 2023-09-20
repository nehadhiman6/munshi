<?php

namespace App\Http\Controllers\Matters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Matters\FileOpening;
use App\Models\Matters\CondoCorporation;
use App\Models\Address\Address;
use DB;
use Gate;

class CondoCorporationController extends Controller
{

    public function save($request)
    {
        $this->validate($request,[
            'condo_corporation.condo_corporation_name'=>'required',
        ]);
        $file_opening = FileOpening::FindOrNew($request->file_opening_id);

        $condo_corporation = CondoCorporation::firstOrNew(['file_opening_id'=>$request['file_opening_id']]);
        $condo_corporation->fill($request->condo_corporation);

        $address = null;
        if($request->condo_corporation['address']){
            $address = Address::firstOrNew(['addressable_id'=> $condo_corporation['id'],'addressable_type'=>CondoCorporation::class]);
            $address->fill($request->condo_corporation['address']);
            $address->addressable_type = CondoCorporation::class;
        }



        DB::beginTransaction();
            $file_opening->condo_corporation()->save($condo_corporation);
            if($address){
                $address->addressable_id =$condo_corporation->id;
                $address->save();
            }
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
