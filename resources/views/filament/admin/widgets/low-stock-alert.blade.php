<x-filament-widgets::widget>
    <x-filament::section>
        @php $variants = $this->getVariants(); @endphp

        @if($variants->count() > 0)
            <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <strong>⚠ Out of Stock Products!</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach($variants as $variant)
                        <li>
                            {{ $variant->product->name }}
                            @if($variant->color) - Color: {{ $variant->color }} @endif
                            @if($variant->size) - Size: {{ $variant->size }} @endif
                            <span class="font-bold">(Qty: {{ $variant->quantity }})</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                ✅ All products are in stock.
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
