<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;

class AutoUpdateOrderStatus extends Command
{
    protected $signature = 'order:auto-update';
    protected $description = 'Otomatis update status order';

    public function handle()
    {
        // Pending → Paid (5 detik)
        $pending = Order::where('status', 'pending')->get();
        foreach ($pending as $order) {
            if ($order->status_changed_at && now()->diffInSeconds($order->status_changed_at) >= 5) {
                $order->update([
                    'status' => 'paid',
                    'status_changed_at' => now()
                ]);
            }
        }

        // Paid → Completed (5 detik)
        $paid = Order::where('status', 'paid')->get();
        foreach ($paid as $order) {
            if ($order->status_changed_at && now()->diffInSeconds($order->status_changed_at) >= 5) {
                $order->update([
                    'status' => 'completed',
                    'status_changed_at' => now()
                ]);
            }
        }

        return self::SUCCESS;
    }

    /**
     * Laravel 11/12 Scheduling langsung di class ini
     */
    public function schedule(\Illuminate\Console\Scheduling\Schedule $schedule)
    {
        $schedule->command(static::class)->everySecond();
    }
}
