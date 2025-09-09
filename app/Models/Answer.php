<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = ['id'];

    public function response(){
        return $this->belongsTo(Response::class);
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
