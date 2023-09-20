<?php

namespace App\Http\Controllers\Matters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matters\Commission;
use App\Models\Address\Address;
use App\Models\Matters\FileOpening;
use App\Models\Resource\Resource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CommissionController extends Controller
{
    public function save($request)
    {
        $this->validate($request, [
            // 'commission.amended_name'=>'required',
        ]);
        $file_opening = FileOpening::FindOrNew($request->file_opening_id);

        $commission = Commission::firstOrNew(['file_opening_id'=>$request['file_opening_id']]);
        $old_detids = $commission->resources()->pluck('id')->toArray();
        $commission->fill($request->commission);

        $address = null;
        if ($request->commission['address']) {
            $address = Address::firstOrNew(['addressable_id'=> $commission['id'],'addressable_type'=>Commission::class]);
            $address->fill($request->commission['address']);
            $address->addressable_type = Commission::class;
        }


        $resources = new Collection();
        foreach ($request->resources as $resource) {
            if ($resource['attachment_id'] > 0) {
                $res = Resource::firstOrNew(['attachment_id'=>$resource['attachment_id'], 'doc_type' => $resource['doc_type'], 'resourceable_type' => Commission::class, 'resourceable_id' => $request->commission_id]);
                $res->attachment_id = $resource['attachment_id'];
                $res->doc_description = $resource['doc_description'];
                $resources->add($res);
            }
        }
        $new_rescources = $resources->pluck('id')->toArray();

        $detach = array_diff($old_detids, $new_rescources);


        DB::beginTransaction();
        $file_opening->commission()->save($commission);
        if ($address) {
            $address->addressable_id =$commission->id;
            $address->save();
        }
        $commission->resources()->saveMany($resources);
        Resource::whereIn('id', $detach)->delete();
        DB::commit();

        $commission->load(['resources.attachment', 'address.city','real_estate_agent','brokerage.address.city']);
        return reply(true, [
            'file_opening' => $file_opening,
            'commission'=>$commission
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

    public function saveFiles(Request $request)
    {
        $commission = Commission::findOrFail($request->commission_id);
        $old_detids = $commission->resources()->pluck('id')->toArray();


        $resources = new Collection();
        foreach ($request->resources as $resource) {
            if ($resource['attachment_id'] > 0) {
                $res = Resource::firstOrNew(['attachment_id'=>$resource['attachment_id'], 'doc_type' => $resource['doc_type'], 'resourceable_type' => Commission::class, 'resourceable_id' => $request->commission_id]);
                $res->attachment_id = $resource['attachment_id'];
                $res->doc_description = $resource['doc_description'];
                $resources->add($res);
            }
        }
        $new_rescources = $resources->pluck('id')->toArray();

        $detach = array_diff($old_detids, $new_rescources);

        DB::beginTransaction();
        $commission->resources()->saveMany($resources);
        Resource::whereIn('id', $detach)->delete();
        DB::commit();
        return reply(true);
    }
}
