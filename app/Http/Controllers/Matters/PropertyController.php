<?php

namespace App\Http\Controllers\Matters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matters\FileOpening;
use App\Models\Matters\Property;
use App\Models\Matters\PropertyPin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PropertyController extends Controller
{
    public function save($request)
    {
        $this->validate($request, [
            // 'property.pins.*.pin'=>'required',
            'property.date' => 'nullable|date_format:m-d-Y',

        ]);
        $file_opening = FileOpening::FindOrNew($request->file_opening_id);

        $property = Property::firstOrNew(['file_opening_id' => $request['file_opening_id']]);
        $property->fill($request->property);


        $old_pins = $property->pins()->pluck('id')->toArray();
        $pins = new Collection();


        foreach ($request->property['pins'] as $pin) {
            $pin_prop = PropertyPin::findOrNew($pin['id']);
            $pin_prop->fill($pin);
            $pins->add($pin_prop);
        }

        $new_pins = $pins->pluck('id')->toArray();
        $detach = array_diff($old_pins, $new_pins);


        DB::beginTransaction();
        $file_opening->property()->save($property);
        $property->pins()->saveMany($pins);
        PropertyPin::whereIn('id', $detach)->delete();
        DB::commit();

        return reply(true, [
            'file_opening' => $file_opening,
            'addressable_type' => FileOpening::class
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
        // $file_opening->load(['clerk','real_estate_agent', 'real_estate_broker', 'solicitor_name']);
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
