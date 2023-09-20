<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masters\PrecedentFormat;

class PrecedentController extends Controller
{

    public function save($request)
    {
        $this->validate($request,[
            'format_text'=>'required',
            'name'=>'required_if:form_id,0'
        ]);
        $precedent = PrecedentFormat::FindOrNew($request->form_id);
        if($request->form_id == 0){
            $precedent->fill($request->all());
        }
        else{
            $precedent->format_text = $request->format_text;
        }
        $precedent->save();
        return reply(true, [
            'precedent' => $precedent
        ]);
    }

    public function store(Request $request)
    {
        return $this->save($request);
    }

    public function update(Request $request)
    {
        return $this->save($request);
    }
}
