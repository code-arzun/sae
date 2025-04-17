<div class="dt-responsive table-responsive">
    <h4>Ringkasan Collection</h4>
        <table class="table text-center mb-5">
            <thead>
                <tr>
                    <th>Subtotal</th>
                    <th colspan="2">Diskon</th>
                    <th>Grand Total</th>
                    @if ($order->payment_status === 'Lunas')
                    @else
                    <th class="text-white bg-danger">Tagihan</th>
                    <th class="text-white bg-success">Telah dibayar</th>
                    @endif
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center accounting subtotal">{{ number_format($order->sub_total) }}</td>
                    <td class="text-center accounting discountPercent">{{ number_format($order->discount_percent, 2) }}</td>
                    <td class="text-center accounting discountRp">{{ number_format($order->discount_rp) }}</td>
                    <td class="text-center accounting grandtotal">{{ number_format($order->grandtotal) }}</td>
                    @if ($order->payment_status === 'Lunas')
                    @else
                    <td class="text-center accounting discountRp">{{ number_format($order->due) }}</td>
                    <td class="text-center accounting subtotal">{{ number_format($order->pay) }}</td>
                    @endif
                    <td class="text-center">
                        @if ($order->payment_status === 'Lunas')
                            <span class="badge bg-success w-100">{{ $order->payment_status }}</span>
                        @elseif ($order->payment_status === 'Belum Lunas')
                            <span class="badge bg-warning w-100">{{ $order->payment_status }}</span>
                        @else
                            <span class="badge bg-danger w-100">{{ $order->payment_status }}</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

    @if ($collections->count() > 0)
    <h4>Riwayat Pembayaran</h4>
        <table class="table bg-gray-100 mb-5">
            <thead class="bg-danger">
                <th>Pembayaran</th>
                <th>Tgl. Coll</th>
                <th width="170px">No. Coll</th>
                <th>Subtotal</th>
                <th class="bg-danger">Diskon</th>
                <th class="bg-danger">Pajak</th>
                <th class="bg-danger">Biaya-biaya</th>
                <th class="bg-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Diskon + Pajak + Biaya">Total Potongan</th>
                <th>Diterima</th>
            </thead>
            <tbody>
                @foreach ($collections as $collection)
                <tr>
                    <td class="text-center">ke- <span class="fw-bold fs-5">{{ $loop->iteration  }}</span></td>
                    <td>
                        <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($collection->payment_date)->translatedformat('l, d F Y') }}">
                            {{ Carbon\Carbon::parse($collection->payment_date)->translatedformat('l, d F Y') }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
                            <div class="d-flex justify-content-between align-items-center">
                                <a class="badge me-2 {{ strpos($collection->invoice_no, '-RO') !== false ? 'bg-primary' : (strpos($collection->invoice_no, '-HO') !== false ? 'bg-danger' : 
                                    (strpos($collection->invoice_no, '-RS') !== false ? 'bg-success' : (strpos($collection->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))) }}" 
                                    href="{{ route('collection.details', $collection->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Pembayaran">
                                    {{ $collection->invoice_no }}
                                </a>
                                <a href="{{ route('collection.invoiceDownload', $collection->id) }}" class="badge bg-secondary me-2" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Cetak Dokumen Collection"><i class="fa fa-print me-0" aria-hidden="true"></i> 
                                </a>
                            </div>
                        @else
                        <a class="badge {{ strpos($collection->invoice_no, '-RO') !== false ? 'bg-primary' : (strpos($collection->invoice_no, '-HO') !== false ? 'bg-danger' : 
                            (strpos($collection->invoice_no, '-RS') !== false ? 'bg-success' : (strpos($collection->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))) }}" 
                            href="{{ route('collection.details', $collection->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Pembayaran">
                            {{ $collection->invoice_no }}
                        </a>
                        @endif
                    </td>
                    <td class="accounting subtotal">{{ number_format($collection->pay) }}</td>
                    <td class="accounting discountRp">{{ number_format($collection->discount_rp) }}</td>
                    <td class="accounting discountRp">{{ number_format($collection->PPh22_rp + $collection->PPN_rp) }}</td>
                    <td class="accounting discountRp">{{ number_format($collection->admin_fee + $collection->other_fee) }}</td>
                    <td class="accounting discountRp">{{ number_format($collection->discount_rp + $collection->PPh22_rp + $collection->PPN_rp + $collection->admin_fee + $collection->other_fee) }}</td>
                    <td class="accounting grandtotal">{{ number_format($collection->grandtotal) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    <h4>Rekap Pembayaran</h4>
        <table class="table">
            <thead class="bg-teal-100">
                <tr>
                    <th width="150px">Total Pembayaran</th>
                    <th class="bg-success">Total Dibayarkan</th>
                    <th class="bg-danger">Total Diskon</th>
                    <th class="bg-danger">Total Pajak</th>
                    <th class="bg-danger" width="200px">Total Biaya-biaya</th>
                    <th class="bg-warning">Total Potongan</th>
                    <th class="bg-primary">Total Akhir Diterima</th>
                    @if ($order->due > 0)
                    <th class="bg-danger">Sisa Tagihan</th>
                    @else
                    @endif
                </tr>
            </thead>
            <tbody>
                    <td class="text-center"><span class="fw-bold fs-5 me-2">{{ number_format($order->collections->count('pay')) }}</span>kali</td>
                    <td class="text-center accounting subtotal">{{ number_format($collections->sum('pay')) }}</td>
                    <td class="text-center accounting discountRp">{{ number_format($collections->sum('discount_rp')) }}</td>
                    <td class="text-center accounting discountRp">
                        {{ number_format($order->collections->sum('PPh22_rp') + $order->collections->sum('PPN_rp')) }}
                    </td>
                    <td class="text-center accounting discountRp">
                        {{ number_format($order->collections->sum('admin_fee') + $order->collections->sum('other_fee')) }}
                    </td>
                    <td class="text-center accounting discountRp">
                        {{ number_format(
                            $collections->sum('discount_rp') + $order->collections->sum('PPh22_rp') + $order->collections->sum('PPN_rp') +
                            $order->collections->sum('admin_fee') + $order->collections->sum('other_fee')
                            ) }}
                    </td>
                    <td class="text-center accounting grandtotal">{{ number_format($order->collections->sum('grandtotal')) }}</td>
                    @if ($order->due > 0)
                    <td class="text-center accounting discountRp">{{ number_format($order->due) }}</td>
                    @else
                    @endif
                </tr>
            </tbody>
        </table>
   @else
        <div class="alert alert-danger text-center" role="alert">
            <strong>
                Pesanan dengan Nomor {{ $order->invoice_no }} belum ada pembayaran.
            </strong>
        </div>
    @endif 
</div>