<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArtPiece extends Model
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

    public function artistId() {
    	return $this->hasOne('App\Artist', 'id', 'artist_id');
    }

    public function categoryId() {
    	return $this->hasOne('App\Category', 'id', 'category_id');
    }
}
