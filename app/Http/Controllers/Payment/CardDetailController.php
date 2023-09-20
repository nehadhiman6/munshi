<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment\CardDetail;
use Illuminate\Http\Request;

class CardDetailController extends Controller
{
    public function index(Request $request){
        $card_detail = CardDetail::first();
        return reply(true,[
            'card_detail' => $card_detail
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'card_name'=>'required|max:200|min:3',
            'card_no'=>'required|numeric|digits:16',
            'cvc'=>'required|digits:3',
            'expiry'=>'required|date_format:Y-m',
        ]);

        $card_details = CardDetail::findOrNew($request['form_id']);
        $card_details->fill($request->all());
        $card_details->expiry = $request['expiry'] .'-01';
        $card_details->save();


        return reply(true,[
            'card_details'=>$card_details
        ]);
    }


}
