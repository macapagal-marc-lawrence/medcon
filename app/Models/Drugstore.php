<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drugstore extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'storename',
        'storeaddress',
        'licenseno',
        'operatingdays',
        'bir_number',
        'latitude',
        'longitude'
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicines()
    {   
    return $this->hasMany(Medicine::class, 'store_id');
    }

}



