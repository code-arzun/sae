<table class="table nowrap mb-3">
    <thead>
        <tr>
            <!-- Partial Head -->
            @include('layout.table.so-head')
            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
            <th width="50px"><i class="ti ti-file-alert"></i></th>
            @endif
            <th class="bg-success">Dibayarkan</th>
            <th class="bg-danger">Tagihan</th>
            <th width="200px"><i class="fas fa-truck me-3"></i>Status Pembayaran</th>
            <th><i class="fas fa-truck me-3"></i>Riwayat Pembayaran</th>
            @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Admin Gudang']))
            <th width="50px">#</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <!-- Partial Data -->
            @include('layout.table.so-data')
            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
                <td class="text-center">
                    <div class="d-flex justify-content-center">
                        {{-- <a class="badge bg-purple-300 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Dokumen Penyiapan Produk" data-original-title="Cetak Dokumen Penyiapan Produk"
                            href="{{ route('do.printPenyiapan', $order->id) }}">
                            <i class="fa fa-print me-0" aria-hidden="true"></i>
                        </a> --}}
                        <!-- Shipping Update -->
                        {{-- @include('layout.partials.shipping-update') --}}
                    </div>
                </td>
            @endif
            <td class="accounting subtotal">{{ number_format($order->pay) }}</td>
            <td class="accounting discountRp">{{ number_format($order->due) }}</td>
            @if ($order->payment_status === 'Belum dibayar')
                <td colspan="2"><span class="badge bg-danger w-100">Belum ada Pembayaran</span></td>
            @else
                <td>
                    @if ($order->payment_status === 'Lunas')
                        <a class="badge bg-success w-100" data-bs-toggle="collapse" href="#detailsColl{{ $order->id }}" aria-expanded="false" aria-controls="detailsColl{{ $order->id }}">{{ $order->payment_status }}</a>
                    @else
                        <a class="badge bg-warning w-100" data-bs-toggle="collapse" href="#detailsColl{{ $order->id }}" aria-expanded="false" aria-controls="detailsColl{{ $order->id }}">{{ $order->payment_status }}</a>    
                    @endif
                </td>
                <td>
                @foreach($order->collections as $collection)
                    <a class="badge 
                        {{ strpos($collection->invoice_no, '-RO') !== false ? 'bg-primary' : 
                           (strpos($collection->invoice_no, '-HO') !== false ? 'bg-danger' : 
                           (strpos($collection->invoice_no, '-RS') !== false ? 'bg-success' : 
                           (strpos($collection->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))) }}" 
                       href="{{ route('collection.details', $collection->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" 
                       title="Lihat Detail Pembayaran">
                        {{ $collection->invoice_no }}
                    </a>
                @endforeach
                </td>
                @endif
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Admin Gudang']))
                <td>
                    @if ($order->payment_status === 'Lunas')
                    @else
                        <a href="{{ route('input.collection', ['order_id' => $order->id]) }}" class="badge bg-purple-500" data-bs-toggle="tooltip" data-bs-placement="top" title="Buat Collection">
                            <i class="ti ti-plus"></i>
                        </a>
                    @endif
                </td>
                @endif
                @if($order->collections->isNotEmpty())
                    <tr>
                        <td class="collapse" colspan="14" id="detailsColl{{ $order->id }}">
                            @include('finance.collection.partials.details', ['collections' => $order->collections])
                        </td>
                    </tr>
                @endif
        </tr>
        @endforeach
    </tbody>
</table>
{{ $orders->links() }}