<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'store_id',
        'total_amount',
        'discounted_amount',
        'status',
        'payment_mode',
        'scheduled_pickup_date',
        'pickup_deadline',
        'picked_up_at',
        'approved_at',
        'rejected_at'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'scheduled_pickup_date' => 'datetime',
        'pickup_deadline' => 'datetime',
        'picked_up_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'customer_id');
    }

    public function store()
    {
        return $this->belongsTo(\App\Models\Drugstore::class, 'store_id');
    }

    /**
     * Approve the order
     * @return bool
     */
    public function approve()
    {
        if ($this->status !== 'pending') {
            throw new \Exception('Order has already been processed.');
        }

        $this->status = 'approved';
        $this->approved_at = now();
        $saved = $this->save();
        
        if ($saved) {
            $this->refresh();
            \Log::info('Order approved via model method:', [
                'order_id' => $this->id,
                'new_status' => $this->status,
                'approved_at' => $this->approved_at
            ]);
        }
        
        return $saved;
    }

    /**
     * Reject the order
     * @return bool
     */
    public function reject()
    {
        if ($this->status !== 'pending') {
            throw new \Exception('Order has already been processed.');
        }

        $this->status = 'rejected';
        $this->rejected_at = now();
        $saved = $this->save();
        
        if ($saved) {
            $this->refresh();
            \Log::info('Order rejected via model method:', [
                'order_id' => $this->id,
                'new_status' => $this->status,
                'rejected_at' => $this->rejected_at
            ]);
        }
        
        return $saved;
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Schedule pickup for the order
     * @param string|DateTime $pickupDate
     * @return bool
     */
    public function schedulePickup($pickupDate)
    {
        $pickupDateTime = is_string($pickupDate) ? new \DateTime($pickupDate) : $pickupDate;
        
        // Set pickup deadline to end of the scheduled day
        $deadline = clone $pickupDateTime;
        $deadline->setTime(23, 59, 59);
        
        $this->scheduled_pickup_date = $pickupDateTime;
        $this->pickup_deadline = $deadline;
        $this->status = 'pending';
        
        return $this->save();
    }

    /**
     * Mark order as picked up
     * @return bool
     */
    public function markAsPickedUp()
    {
        $this->picked_up_at = now();
        $this->status = 'completed';
        return $this->save();
    }

    /**
     * Check if order is past pickup deadline
     * @return bool
     */
    public function isPastDeadline()
    {
        if (!$this->pickup_deadline) {
            return false;
        }
        return now() > $this->pickup_deadline;
    }

    /**
     * Void the order if past deadline
     * @return bool
     */
    public function voidIfPastDeadline()
    {
        if ($this->isPastDeadline() && $this->status === 'pending') {
            $this->status = 'voided';
            return $this->save();
        }
        return false;
    }
}