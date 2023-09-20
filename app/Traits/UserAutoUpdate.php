<?php

namespace App\Traits;

use Gate;
use DB;

trait UserAutoUpdate {

  protected static function boot() {

    parent::boot();

    static::creating(function($model) {
        if (!auth()->guest()) {
            $model->created_by = auth()->user()->id;
        }

        if (method_exists($model, 'saveAttributes')) {
            $model->saveAttributes();
        }
    });

    static::updating(function($model) {
            if (!auth()->guest()) {
                $model->updated_by = auth('web')->user()->id;
            }
        });
    }

    public function user_created() {
            return $this->belongsTo(\App\Models\Auth\User::class, 'created_by', 'id');
    }

    public function user_modified() {
            return $this->belongsTo(\App\Models\Auth\User::class, 'updated_by', 'id');
    }

}
