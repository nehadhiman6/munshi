<?php

namespace App\Http\Controllers\Matters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Matters\FileOpening;
use App\Models\Matters\Seller;
use App\Models\Matters\SellerId;
use App\Models\Address\Address;
use App\Models\Resource\Resource;

use DB;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('file-openings')) {
            return deny();
        }
        if ($request->ajax()) {
            $count = FileOpening::all()->count();
            $filteredCount = $count;
            $file_openings = FileOpening::orderBy('id', 'DESC');

            if ($searchStr = $request->input('search.value')) {
                $file_openings = $file_openings->where('', 'like', "%{$searchStr}%");
            }

            $file_openings = $file_openings->take($request->length);
            $filteredCount = $file_openings->count();

            if ($request->start > 0) {
                $file_openings->skip($request->start - 1);
            }

            $file_openings = $file_openings->select()->distinct()->get();
            $file_openings->load([]);
            return [
                'draw' => intval($request->draw),
                'start'=>$request->start,
                'data' => $file_openings,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
        }

        return view('matters.file_opeing_file', compact('file_opening'));
    }

    public function save($request)
    {
        $this->validate($request, [
            'sellers.*.salutation'=>'required',
            'sellers.*.email'=>'nullable|email',
            'sellers.*.seller_ids.*.expiry_date'=>'nullable|date_format:m-d-Y',
            'sellers.*.file_review_date'=>'nullable|date_format:m-d-Y',
            'sellers.*.meeting_date'=>'nullable|date_format:m-d-Y',
        ]);
        $file_opening = FileOpening::FindOrNew($request->file_opening_id);
        $old_seller =$file_opening->sellers()->pluck('id')->toArray();


        $sellers = new Collection();


        foreach ($request->sellers as $seller) {
            $sell = Seller::findOrNew($seller['id']);
            $sell->fill($seller);

            $current_add = Address::firstOrNew(['addressable_id'=> $seller['id'],'addressable_type'=>Seller::class,'type'=>'current']);
            $current_add->fill($seller['current_address']);
            $current_add->addressable_type = Seller::class;
            $sell->current_address = $current_add;

            // $closing_add = Address::firstOrNew(['addressable_id'=> $seller['id'],'addressable_type'=>Seller::class,'type'=>'closing']);
            // $closing_add->fill($seller['closing_address']);
            // $closing_add->addressable_type = Seller::class;
            // $sell->closing_address = $closing_add;

            $delete_resources= [];
            $seller_ids = new Collection();
            foreach ($seller['seller_ids'] as $seller_id) {
                $seller_identity = SellerId::findOrNew($seller_id['id']);
                $seller_identity->fill($seller_id);

                $resources = new Collection();
                foreach ($seller_id['resources'] as $res) {
                    if ($res['attachment_id'] > 0) {
                        // $reso = Resource::findOrNew($res['id']);
                        $reso = Resource::firstOrNew(['resourceable_type'=> SellerId::class ,'resourceable_id'=> $seller_id['id']]);
                        $reso->resourceable_type = SellerId::class;
                        $reso->fill($res);
                        $resources->add($reso);
                    }
                    else{
                        $resource_id = Resource::firstOrNew(['resourceable_type'=> SellerId::class ,'resourceable_id'=> $seller_id['id']]);
                        if($resource_id){
                            array_push($delete_resources,$resource_id['id']);

                        }
                    }
                }
                $seller_identity['resources'] = $resources;
                $seller_ids->add($seller_identity);
            }

            $sell->seller_id = $seller_ids;
            $sellers->add($sell);
        }

        $new_sellers = $sellers->pluck('id')->toArray();
        $detach = array_diff($old_seller, $new_sellers);


        DB::beginTransaction();
        foreach ($sellers as $sel) {
            $current_address_copy = $sel['current_address'];
            unset($sel['current_address']);
            // $closing_address_copy =$sel['closing_address'];
            unset($sel['closing_address']);
            $sel_id_copy = $sel['seller_id'];
            unset($sel['seller_id']);
            $sel->save();
            $current_address_copy->addressable_id =$sel['id'];
            // $closing_address_copy->addressable_id =$sel['id'];

            foreach ($sel_id_copy as $sellerid) {
                $id_resources =$sellerid['resources'];
                unset($sellerid['resources']);
                $sellerid->seller_id = $sel->id;
                $sellerid->save();
                $sellerid->resources()->saveMany($id_resources);
            }
            $current_address_copy->save();
            // $closing_address_copy->save();
            // $sel_id_copy->save();
        }

        Seller::whereIn('id', $detach)->delete();
        Address::where('addressable_type', Seller::class)->whereIn('addressable_id', $detach)->delete();
            Resource::whereIn('id',$delete_resources)->delete();
        DB::commit();

        return reply(true, [
            'file_opening' => $file_opening,
            'addressable_type'=> FileOpening::class
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
