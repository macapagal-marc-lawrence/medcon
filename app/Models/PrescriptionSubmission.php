<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionSubmission extends Model
{
    use HasFactory;

    protected $table = 'prescription_submissions';

    protected $fillable = [
        'customer_id',
        'drugstore_id',
        'file_path',
        'description',
        'status',
        'customer_notified',
        'sent_at',
    ];

    // 🔗 Relationship to Prescription
    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id');
    }

    // 🔗 Relationship to Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // 🔗 Relationship to Drugstore
    public function drugstore()
    {
        return $this->belongsTo(Drugstore::class, 'drugstore_id');
    }

    // ✅ Optional: Accessor to make status look better automatically
    public function getFormattedStatusAttribute()
    {
        return ucfirst($this->status ?? 'Pending');
    }

    // ✅ Optional: Helper for status color (for Blade display)
    public function getStatusClassAttribute()
    {
        return match ($this->status) {
            'approved' => 'status-approved approved',
            'rejected' => 'status-rejected rejected',
            'reviewed' => 'status-reviewed reviewed',
            default => 'status-pending pending',
        };
    }
}
