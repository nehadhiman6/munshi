<?php

namespace App\Http\Controllers\Matters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matters\FileOpening;
use App\Models\Matters\RedirectionFund;
use DB;
use Illuminate\Database\Eloquent\Collection;


class RedirectionFundController extends Controller
{
        public function store(Request $request){
        $this->validate($request,[
            'file_opening_id' => 'required|integer',
            'trust_ledgers.*.particulars' =>'required'
        ]);

        return $this->save($request);

    }

    public function save($request){
        $file_opening = FileOpening::findOrFail($request['file_opening_id']);
        $old_redirection_funds = $file_opening->redirection_funds()->pluck('id')->toArray();

        $redirection_funds = new Collection();
        $count = 1;
        foreach($request->redirection_funds as $redirection_fund){
            if(!($redirection_fund['custom'] == 'N' &&  $redirection_fund['amount'] == '')){
                $trust_led = RedirectionFund::findOrNew($redirection_fund['id']);
                $trust_led->fill($redirection_fund);
                $trust_led->order_no = $count++;
                $redirection_funds->add($trust_led);
            }
        }

        $new_ids = $file_opening->redirection_funds()->pluck('id')->toArray();

        $detach = array_diff($old_redirection_funds,$new_ids);

        DB::beginTransaction();
            // $redirection_funds->save();
            $file_opening->redirection_funds()->saveMany($redirection_funds);
            RedirectionFund::whereIn('id',$detach)->delete();
        DB::commit();

        return reply(true,[
            'redirection_funds'=>$redirection_funds
        ]);
    }
}
