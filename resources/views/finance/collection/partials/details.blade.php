<h4>Riwayat Pembayaran</h4>
<table class="table bg-gray-100 mb-3">
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
            <th>Total Pembayaran</th>
            <th>Total Dibayarkan</th>
            <th>Total Diskon</th>
            <th>Total Pajak</th>
            <th>Total Biaya-biaya</th>
            <th>Total Potongan</th>
            <th>Total Akhir Diterima</th>
        </tr>
    </thead>
    <tbody>
            <th><span class="badge bg-success">{{ number_format($order->collections->count('pay')) }} kali</span></th>
            <th><span class="badge bg-success">Rp {{ number_format($collections->sum('pay')) }}</span></th>
            <th><span class="badge bg-danger">Rp {{ number_format($collections->sum('discount_rp')) }}</span></th>
            <th>
                <span class="badge bg-danger">
                    Rp {{ number_format($order->collections->sum('PPh22_rp') + $order->collections->sum('PPN_rp')) }}
                </span>
            </th>
            <th>
                <span class="badge bg-danger">
                    Rp {{ number_format($order->collections->sum('admin_fee') + $order->collections->sum('other_fee')) }}
                </span>
            </th>
            <th>
                <span class="badge bg-warning">
                    Rp {{ number_format(
                        $collections->sum('discount_rp') + $order->collections->sum('PPh22_rp') + $order->collections->sum('PPN_rp') +
                        $order->collections->sum('admin_fee') + $order->collections->sum('other_fee')
                        ) }}
                </span>
            </th>
            <th><span class="badge bg-primary">Rp {{ number_format($order->collections->sum('grandtotal')) }}</span></th>
        </tr>
        @if ($order->due > 0)
        <tr>
            <th colspan="3" class="text-end">Sisa Tagihan</th>
            <th class="text-end">
                <span class="badge bg-danger">
                    Rp {{ number_format($order->due) }}
                </span>
            </th>
        </tr>
        @else
        @endif
    </tbody>
</table>