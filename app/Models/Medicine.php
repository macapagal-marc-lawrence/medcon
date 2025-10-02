<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'medicine_name',
        'generic_name',
        'description',
        'medicine_price',
        'quantity',
        'manufactured_date',
        'expiration_date',
        'medicine_img',
    ];

    // Relationship to Drugstore
    public function store()
    {
        return $this->belongsTo(Drugstore::class, 'store_id');
    }
}

