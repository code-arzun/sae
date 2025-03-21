<!-- Download button -->
<a href="{{ route('so.invoiceDownload', $order->id) }}"
    class="btn btn-primary mb-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Dokumen SO">
    <i class="fa fa-print me-2" aria-hidden="true"></i> Dokumen SO
</a>

<!-- Detail Table -->
<table class="table bg-white nowrap mb-3">
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
        @foreach ($orderDetails as $item)
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
    {{-- <tfoot class="text-end">
        <tr>
            <th colspan="3"><span class="me-3">Jumlah Item</span>{{ number_format($orderDetails->count('order_id')) }}</th>
            <th><span class="me-3">Total Produk</span>{{ number_format($order->total_products) }}</th>
            <th>Subtotal</th>
            <td><span class="badge bg-success">Rp {{ number_format($order->sub_total) }}</td>
        </tr>
        <tr>
            <th colspan="5">Diskon</th>
            <td><span class="badge bg-warning me-3">{{ number_format($order->discount_percent, 2) }}%</span><span class="badge bg-danger">Rp {{ number_format($order->discount_rp) }}</span></td>
        </tr>
    </tfoot> --}}
</table>

<div class="offset-6">
    <table class="table text-end">
            <tr>
                <th class="text-start">Jumlah Item</th>
                <td class="text-start"><span class="badge bg-secondary">{{ number_format($orderDetails->count('order_id')) }}</span></td>
                <th class="text-start">Total Produk</th>
                <td class="text-start"><span class="badge bg-secondary me-2">{{ number_format($order->total_products) }}</span>{{ $item->product->category->productunit->name }}</td>
                <th>Subtotal</th>
                <td><span class="badge bg-success">Rp {{ number_format($order->sub_total) }}</td>
            </tr>
            <tr>
                <th colspan="4">Diskon</th>
                <td><span class="badge bg-warning">{{ number_format($order->discount_percent, 2) }}%</span></td>
                <td><span class="badge bg-danger">Rp {{ number_format($order->discount_rp) }}</span></td>
            </tr>
            <tr>
                <th colspan="5">Grand Total</th>
                <td><span class="badge bg-primary">Rp {{ number_format($order->grandtotal) }}</td>
            </tr>
        </tbody>
    </table>
</div>