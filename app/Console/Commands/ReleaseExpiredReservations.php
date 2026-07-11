<?php

namespace App\Console\Commands;

use App\Services\StockReservationService;
use Illuminate\Console\Command;

class ReleaseExpiredReservations extends Command
{
    protected $signature = 'reservations:release-expired';
    protected $description = 'Release expired stock reservations and restore product stock.';

    public function handle(StockReservationService $service): int
    {
        $count = $service->releaseExpired();

        if ($count === 0) {
            $this->info('No expired reservations found.');
        } else {
            $this->info("Released {$count} expired reservation(s) and restored stock.");
        }

        return self::SUCCESS;
    }
}
