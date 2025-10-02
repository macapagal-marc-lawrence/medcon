<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = [
        'store_id',
        'customer_id',
        'medicine_id',
        'order_id',
        'quantity',
    ];

    // Relationships
    public function store()
    {
        return $this->belongsTo(Drugstore::class, 'store_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}

