<?php

namespace App\Http\Controllers\Matters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Matters\FileOpening;
use App\Models\Matters\Purchaser;
use App\Models\Matters\SolicitorPurchaser;
use DB;
use Gate;

class PurchaserController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('file-openings')) {
            return deny();
        }
        if ($request->ajax()) {
            $count = FileOpening::all()->count();
            $filteredCount = $count;
            $file_openings = FileOpening::orderBy('id','DESC');

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

        return view('matters.file_opeing_file',compact('file_opening'));
    }

    public function save($request)
    {
        $this->validate($request,[
            'purchasers.*.salutation'=>'required',
            'purchasers.*.first_name'=>'required_unless:salutation,Corporation',
            'purchasers.*.company_name'=>'required_if:salutation,Corporation',
            'purchasers.*.dob'=>'nullable|date_format:m-d-Y',
            'purchasers.*.other_title_capacity'=>'required_if:purchasers.*.title_capacity,title_capacity,others',
        ]);
        $file_opening = FileOpening::FindOrNew($request->file_opening_id);
        $old_purchasers = $file_opening->purchasers()->pluck('id')->toArray();


        $purchasers = new Collection();


        foreach($request->purchasers as $purchaser){
            $pur = Purchaser::findOrNew($purchaser['id']);
            $pur->fill($purchaser);
            $purchasers->add($pur);
        }


        $solicitor_purchaser = SolicitorPurchaser::firstOrNew(['file_opening_id'=>$request->file_opening_id]);
        $solicitor_purchaser->fill($request->purchaser_solicitor);

        $new_purchasers = $purchasers->pluck('id')->toArray();
        $detach = array_diff($old_purchasers, $new_purchasers);


        DB::beginTransaction();
            $file_opening->purchasers()->saveMany($purchasers);
            $solicitor_purchaser->save();
            Purchaser::whereIn('id', $detach)->delete();
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
