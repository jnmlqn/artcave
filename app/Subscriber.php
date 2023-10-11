<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $appends = [
    	'name'
    ];

    public function getNameAttribute() {
    	return $this->first_name . ' ' . $this->last_name;
    }
}
