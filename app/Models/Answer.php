<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{


    public function responses(){
        return $this->hasMany(Response::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }
}
