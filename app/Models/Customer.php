<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'firstname',
        'middlename',
        'lastname',
        'age',
        'birthdate',
        'sex',
        'address',
        'avatar',
        'latitude',
        'longitude',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

        public function prescriptionSubmissions()
    {
        return $this->hasMany(PrescriptionSubmission::class, 'customer_id');
    }

}
