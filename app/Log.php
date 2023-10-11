<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function userId() {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }

    public static function createLog($action) {
    	$user = request()->user();
    	Log::insert([
    		'action' => $action,
    		'user_id' => $user->id
    	]);
    }
}
