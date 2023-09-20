<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\Address\Address;

trait Addressable {

    public function address() {
      return $this->morphOne(Address::class, 'addressable');
    }

}
