@props(['product', 'index' => 0])

<a href="{{ route('products.show', $product) }}" class="card card-hover overflow-hidden group animate-fade-in-up" style="animation-delay: {{ $index * 0.05 }}s">
    <div class="h-40 bg-dark-50 overflow-hidden relative">
        @if ($product->first_image)
            <img src="{{ asset('storage/' . $product->first_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-12 h-12 text-dark-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </div>
        @endif
        @if ($product->condition === 'used')
            <span class="absolute top-2 left-2 badge bg-amber-100 text-amber-700 text-[9px]">Bekas</span>
        @endif
    </div>
    <div class="p-4 space-y-2">
        <p class="text-xs text-dark-400 truncate">{{ $product->sellerProfile?->store_name }}</p>
        <h3 class="text-sm font-medium text-dark-900 line-clamp-2 leading-snug min-h-[2.5rem]">{{ $product->name }}</h3>
        <p class="text-base font-bold font-display text-primary-600">{{ $product->formatted_price }}</p>
        <div class="flex items-center justify-between pt-1">
            @if ($product->review_count > 0)
                <span class="text-[10px] text-amber-500 font-medium flex items-center gap-0.5">
                    ★ {{ number_format($product->rating, 1) }}
                    <span class="text-dark-400">({{ $product->review_count }})</span>
                </span>
            @else
                <span class="text-[10px] text-dark-300">Belum ada ulasan</span>
            @endif
            <span class="text-[10px] text-dark-400">{{ $product->total_sold }} terjual</span>
        </div>
    </div>
</a>
