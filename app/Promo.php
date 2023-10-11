<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
	protected $casts = [
		'id' => 'string'
	];	

    public function createdBy() {
    	return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function updatedBy() {
    	return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
