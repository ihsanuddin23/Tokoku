<?php

namespace App\Listeners;

use App\Events\StockUpdated;
use App\Services\StockNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendStockRestockedNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(StockUpdated $event): void
    {
        if (! $event->wasRestocked()) {
            return;
        }

        $service = app(StockNotificationService::class);

        if ($event->variant) {
            $service->notifyVariantRestocked($event->variant->id, $event->newStock);
        } else {
            $service->notifyProductRestocked($event->product);
        }
    }
}
