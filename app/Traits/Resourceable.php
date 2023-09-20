<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\Resource\Resource;

trait Resourceable {

    public function resources() {
      return $this->morphMany(Resource::class, 'resourceable');
    }

}
