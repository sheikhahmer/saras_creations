<table class="w-full table-auto border-collapse border border-gray-200">
    <thead>
        <tr class="bg-gray-100">
            <th class="border px-2 py-1">ID</th>
            <th class="border px-2 py-1">SKU</th>
            <th class="border px-2 py-1">Name</th>
            <th class="border px-2 py-1">Size</th>
            <th class="border px-2 py-1">Color</th>
            <th class="border px-2 py-1">Quantity</th>
            <th class="border px-2 py-1">Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($variants as $variant)
            <tr>
                <td class="border px-2 py-1">{{ $variant->id }}</td>
                <td class="border px-2 py-1">{{ $variant->sku }}</td>
                <td class="border px-2 py-1">{{ $variant->name }}</td>
                <td class="border px-2 py-1">{{ $variant->size }}</td>
                <td class="border px-2 py-1">{{ $variant->color }}</td>
                <td class="border px-2 py-1">{{ $variant->quantity }}</td>
                <td class="border px-2 py-1">₹{{ $variant->price }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
