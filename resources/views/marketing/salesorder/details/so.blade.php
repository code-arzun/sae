<!-- Download button -->
<a href="{{ route('so.invoiceDownload', $order->id) }}"
    class="btn btn-primary mb-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Dokumen SO">
    <i class="fa fa-print me-2" aria-hidden="true"></i> Dokumen SO
</a>

<!-- Detail Table -->
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
</table>
<div class="d-flex justify-content-between">
    <div class="col-md-2">
        <table class="table">
            <thead>
                <th>Jumlah Item</th>
                <th>Total Produk</th>
            </thead>
            <tbody class="text-center">
                <td><span class="fw-bold fs-5">{{ number_format($orderDetails->count('order_id')) }}</span></td>
                <td><span class="fw-bold fs-5 me-2">{{ number_format($order->total_products) }}</span>{{ $item->product->category->productunit->name }}</td>
            </tr>
        </table>
    </div>
    <div class="col-md-2">
        <table class="table">
                <tr>
                    <th colspan="2">Subtotal</th>
                    <td class="accounting subtotal">{{ number_format($order->sub_total) }}</td>
                </tr>
                <tr>
                    <th>Diskon</th>
                    <td class="accounting discountPercent">{{ number_format($order->discount_percent, 2) }}</td>
                    <td class="accounting discountRp">{{ number_format($order->discount_rp) }}</td>
                </tr>
                <tr>
                    <th colspan="2">Grand Total</th>
                    <td class="accounting grandtotal">{{ number_format($order->grandtotal) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>