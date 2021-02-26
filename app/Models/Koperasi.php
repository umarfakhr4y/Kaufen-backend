<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koperasi extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);        
    }

    public function img(){
		return $this->hasMany(Image::class, 'image_id');
	}
}
