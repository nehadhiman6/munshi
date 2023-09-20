<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use DB;
use App\Models\Masters\TransactionType;

class TransactionTypeController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::denies('transaction-type-list')) {
            return deny();
        }
        if ($request->ajax()) {
            $count = TransactionType::all()->count();
            $filteredCount = $count;
            $transaction_types = TransactionType::orderBy('id','DESC');

            if ($searchStr = $request->input('search.value')) {
                $transaction_types = $transaction_types->where('type_name', 'like', "%{$searchStr}%");
            }

            $transaction_types = $transaction_types->take($request->length);
            $filteredCount = $transaction_types->count();

            if ($request->start > 0) {
                $transaction_types->skip($request->start - 1);
            }

            $transaction_types = $transaction_types->select()->distinct()->get();
            return [
                'draw' => intval($request->draw),
                'start'=>$request->start,
                'data' => $transaction_types,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
        }
        return view('masters.transaction_type');
    }

    public function save($request)
    {
        $this->validate($request,[
            'type_name'=>'required|unique:transaction_types,type_name,'.$request->form_id,
        ]);
        $transaction_type = TransactionType::findOrNew($request->form_id);
        $transaction_type->fill($request->all());
        DB::beginTransaction();
            $transaction_type->save();
        DB::commit();

        return reply(true, [
            'transaction_type' => $transaction_type,
        ]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('transaction-type-modify')) {
            return deny();
        }
        return $this->save($request);
    }

    public function edit($id)
    {
        if (Gate::denies('transaction-type-modify')) {
            return deny();
        }
        $transaction_type = TransactionType::findOrFail($id);
        return reply(true, [
            'transaction_type' => $transaction_type
        ]);
    }


    public function update(Request $request, $id)
    {
        if (Gate::denies('transaction-type-modify')) {
            return deny();
        }
        return $this->save($request);
    }

}
