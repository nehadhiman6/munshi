<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Jobs\SendRecLedgerData;
use App\Models\Company\Company;
use App\Models\Liesure\Leisure;
use App\Models\Payment\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        return view('payment.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'card_name' => 'required',
            'amount' => 'numeric|required|not_in:0'
        ]);
        if (round($request['amount']) > 0) {
            $intent = PaymentIntent::create([
                'amount' => $request['amount'] * 100,
                'currency' => 'usd',
                'receipt_email' => auth()->check() ? auth()->user()->email : $request->email,
                // Verify your integration in this guide by including this parameter
                'metadata' => [
                    'integration_check' => 'accept_a_payment',
                    // 'user_id' => $request->user_id,
                ],
            ]);
            return reply(true, [
                'intent' => $intent
            ]);
        }
    }

    public function savePaymentTransaction(Request $request)
    {
        $this->validate($request, [
            'payment_result' => 'required'
        ]);
        $transaction = new Transaction();
        $transaction->liesure_id = 0;
        $transaction->transaction_id = $request->payment_result['id'];
        $transaction->transaction_status = $request->payment_result['status'];
        $transaction->transaction_date = getToday('Y-m-d');
        $transaction->amount_received =  $request['amount'];
        $transaction->payment_type = 'stripe';
        $transaction->currency =   $request->payment_result['currency'];
        $transaction->source =  $request->payment_result['source'];
        $comp = Company::first();
        if ($request->payment_result['status'] == 'succeeded') {
            $liesure = new Leisure();
            $liesure->trans_date =  getToday('m-d-Y');
            $liesure->particulars = "";
            $liesure->cr_amount = $request['amount'];
            $liesure->dr_amount = 0;
            $liesure->organization_id = $comp->organization_id;
            $liesure->vcode = 'TR';
        }
        DB::beginTransaction();
        $liesure->save();
        $transaction->liesure_id = $liesure->id;
        $transaction->save();
        $liesure->vcode = 'TR' . $transaction->id;
        $liesure->save();
        DB::commit();
        dispatch(new SendRecLedgerData());
        // dd($request->payment_result['status']);
        return reply(true, [
            'payment_status' => $request->payment_result['status']
        ]);
    }
}
