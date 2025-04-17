<table class="table nowrap mb-3">
    <thead>
        <tr>
            <th width="3px">No.</th>
            <th>Produk</th>
            <th width="250px">Kategori</th>
            <th width="150px">Jumlah</th>
            {{-- <th>Terkirim</th> --}}
            {{-- <th>Belum Dikirim</th> --}}
            {{-- <th>Siap Kirim</th> --}}
            <th width="150px">Harga Satuan</th>
            <th width="200px">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($deliveryDetails as $item)
        <tr>
            <td>{{ $loop->iteration  }}</td>
            <td><b>{{ $item->product->product_name }}</b></td>
            <td>{{ $item->product->category->name }}</td>
            <td class="text-center"><b class="me-1">{{ number_format($item->quantity) }}</b>{{ $item->product->category->productunit->name }}</td>
            {{-- <td class="text-center"><span class="badge bg-purple me-2">{{ number_format($item->quantity) }}</span>{{ $item->product->category->productunit->name }}</td> --}}
            {{-- <td class="text-center"><span class="badge bg-success me-2">{{ number_format($item->quantity) }}</span>{{ $item->product->category->productunit->name }}</td> --}}
            {{-- <td class="text-center"><span class="badge bg-danger me-2">{{ number_format($item->quantity) }}</span>{{ $item->product->category->productunit->name }}</td> --}}
            {{-- <td class="text-center"><span class="badge bg-warning me-2">{{ number_format($item->quantity) }}</span>{{ $item->product->category->productunit->name }}</td> --}}
            <td class="text-end">Rp {{ number_format($item->unitcost) }}</td>
            <td class="text-end">Rp {{ number_format($item->total) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="offset-6">
    <table class="table text-end">
            <tr>
                <th class="text-start">Jumlah Item</th>
                <td class="text-start"><span class="badge bg-secondary">{{ number_format($deliveryDetails->count('product')) }}</span></td>
                <th class="text-start">Total Produk</th>
                <td class="text-start"><span class="badge bg-secondary me-2">{{ number_format($delivery->total_products) }}</span>{{ $item->product->category->productunit->name }}</td>
                <th>Subtotal</th>
                <td><span class="badge bg-success">Rp {{ number_format($delivery->sub_total) }}</td>
            </tr>
        </tbody>
    </table>
</div>