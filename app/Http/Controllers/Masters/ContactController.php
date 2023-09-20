<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Masters\Contact;
use App\Models\Address\Address;
use DB;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('contacts-list')) {
            return deny();
        }
        if ($request->ajax()) {
            $count = Contact::where('type','mortgagee')->count();
            $filteredCount = $count;
            $contacts = Contact::where('type','mortgagee')->orderBy('id','DESC');

            if ($searchStr = $request->input('search.value')) {
                $contacts = $contacts->where('first_name', 'like', "%{$searchStr}%")
                ->orWhere('middle_name', 'like', "%{$searchStr}%")
                ->orWhere('last_name', 'like', "%{$searchStr}%")
                ->orWhere('company_name', 'like', "%{$searchStr}%")
                ->orWhere('email', 'like', "%{$searchStr}%");
            }

            $contacts = $contacts->take($request->length);
            $filteredCount = $contacts->count();

            if ($request->start > 0) {
                $contacts->skip($request->start - 1);
            }

            $contacts = $contacts->select()->distinct()->get();
            $contacts->load([]);
            return [
                'draw' => intval($request->draw),
                'start'=>$request->start,
                'data' => $contacts,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
        }
        return view('masters.contacts');
        // return view('dashboard.dashboard');
    }

    public function save($request)
    {
        $this->validate($request,[
            'first_name'=>'required_unless:type,mortgagee',
            'company_name'=>'required|required_if:type,mortgagee',
            'type'=>'required',
            'email'=>'required|email|unique:contacts,email,'.$request->form_id,
        ]);
        $contact = Contact::FindOrNew($request->form_id);
        $contact->fill($request->all());


        $address = Address::firstOrNew(['addressable_type'=>Contact::class,'addressable_id'=>$request->form_id]);
        $address->fill($request->address);
        $address->addressable_type =Contact::class ;
        $address->addressable_id = $request->form_id;

        DB::beginTransaction();
        $contact->save();
        $address->addressable_id = $contact->id;
        $address->save();
        DB::commit();

        return reply(true, [
            'contact' => $contact,
        ]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('contacts-modify')) {
            return deny();
        }
        return $this->save($request);
    }

    public function edit($id)
    {
        if (Gate::denies('contacts-modify')) {
            return deny();
        }
        $contact = Contact::findOrFail($id);
        $contact->load('address.city');
        return reply(true, [
            'contact' => $contact
        ]);
    }


    public function show($id)
    {
        if (Gate::denies('contacts-modify')) {
            return deny();
        }
        $contact = Contact::findOrFail($id);
        $contact->load('address.city');
        return reply(true, [
            'contact' => $contact
        ]);
    }



    public function update(Request $request, $id)
    {
        if (Gate::denies('contacts-modify')) {
            return deny();
        }
        return $this->save($request);
    }
}
