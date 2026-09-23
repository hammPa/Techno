<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class CancelExpiredBookings extends Command
{
    protected $signature = 'bookings:cancel-expired';
    protected $description = 'Otomatis membatalkan pesanan yang melewati batas waktu transfer';

    public function handle(): int
    {
        $now = now();

        // Cari booking berstatus waiting_payment, belum bayar, dan sudah lewat deadline
        $expiredBookings = Booking::where('status', 'waiting_payment')
            ->where('payment_status', 'unpaid')
            ->whereNotNull('payment_deadline')
            ->where('payment_deadline', '<', $now)
            ->get();

        $count = $expiredBookings->count();

        foreach ($expiredBookings as $booking) {
            $booking->update([
                'status' => 'cancelled',
                'cancellation_reason' => 'Dibatalkan otomatis oleh sistem (melewati batas waktu pembayaran).',
                'cancelled_by' => null, // null menandakan sistem yang membatalkan
                'cancelled_at' => $now,
            ]);
        }

        $this->info("Berhasil membatalkan {$count} pesanan yang kedaluwarsa.");

        return Command::SUCCESS;
    }
}