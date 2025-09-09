<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllowedDomain extends Model
{
    protected $guarded = ['id'];
    public function form(){
        return $this->belongsTo(Form::class);
    }
}
