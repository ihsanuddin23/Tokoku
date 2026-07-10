<?php

namespace App\Events;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockUpdated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Product $product,
        public int $oldStock,
        public int $newStock,
        public ?ProductVariant $variant = null
    ) {}

    public function wasRestocked(): bool
    {
        return $this->oldStock <= 0 && $this->newStock > 0;
    }
}
