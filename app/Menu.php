<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function createdBy() {
    	return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function updatedBy() {
    	return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
