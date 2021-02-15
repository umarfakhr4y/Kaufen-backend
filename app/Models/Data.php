<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory, HasRoles;

    protected $primaryKey = "name";

    protected $table = 'datas';
    
    public $keyType = "string";

    public $incrementing = false;

    protected $fillable = [
        'name' ,     
        'alamat',   
        'noTelp',
        'email',
    ];

    public function loans()
    {       
        return $this->hasMany(Loans::class, 'name');
    }

    public function deposit()
    {       
        return $this->hasMany(Deposit::class, 'name');
    }

    public function barang()
    {       
        return $this->hasMany(Barang::class, 'name');
    }

    public function user()
    {
        return $this->belongsTo(User::class);        
    }
}
