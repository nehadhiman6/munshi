<?php

namespace App\Http\Controllers\Matters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matters\FileOpening;
use App\Models\Matters\TrustLedger;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class TrustLedgerController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'file_opening_id' => 'required|integer',
            'trust_ledgers.*.particulars' =>'required'
        ]);

        return $this->save($request);
    }

    public function save($request)
    {
        $file_opening = FileOpening::findOrFail($request['file_opening_id']);
        $old_trust_ledgers = $file_opening->trust_ledgers()->pluck('id')->toArray();

        $trust_ledgers = new Collection();
        $count = 1;
        foreach ($request->trust_ledgers as $trust_ledger) {
            if (!($trust_ledger['custom'] == 'N' &&  $trust_ledger['amount'] == '')) {
                $trust_led = TrustLedger::findOrNew($trust_ledger['id']);
                $trust_led->fill($trust_ledger);
                $trust_led->order_no = $count++;
                $trust_ledgers->add($trust_led);
            }
        }

        $new_ids = $trust_ledgers->pluck('id')->toArray();
        $detach = array_diff($old_trust_ledgers, $new_ids);

        DB::beginTransaction();
        // $trust_ledgers->save();
        $file_opening->trust_ledgers()->saveMany($trust_ledgers);
        TrustLedger::whereIn('id', $detach)->delete();
        DB::commit();

        return reply(true, [
            'trust_ledgers'=>$trust_ledgers
        ]);
    }
}
