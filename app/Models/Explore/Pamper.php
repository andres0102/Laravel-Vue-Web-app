<?php

namespace App\Models\Explore;

use Illuminate\Database\Eloquent\Model;

class Pamper extends Model
{
    public function user(){
    	return $this->belongsTo('App\User');
    }
}
