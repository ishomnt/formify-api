<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{


    public function form(){
        return $this->belongsTo(Form::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }
}
