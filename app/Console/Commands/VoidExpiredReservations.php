<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class VoidExpiredReservations extends Command
{
    protected $signature = 'orders:void-expired';
    protected $description = 'Void all expired order reservations';

    public function handle()
    {
        $expiredOrders = Order::where('status', 'pending')
            ->whereNotNull('pickup_deadline')
            ->where('pickup_deadline', '<', now())
            ->get();

        $count = 0;
        foreach ($expiredOrders as $order) {
            if ($order->voidIfPastDeadline()) {
                $count++;
            }
        }

        $this->info("Voided {$count} expired reservations.");
    }
}
