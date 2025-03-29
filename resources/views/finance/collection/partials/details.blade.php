<h4>Riwayat Pembayaran</h4>
<table class="table bg-gray-100">
    <thead class="bg-danger">
        <th>Pembayaran ke-</th>
        <th>Tgl. Coll</th>
        <th width="170px">No. Coll</th>
        <th>Subtotal</th>
        <th>Diskon</th>
        <th>Pajak</th>
        <th>Biaya-biaya</th>
        <th>Diterima</th>
        <th>Status</th>
    </thead>
    <tbody>
        @foreach ($collections as $collection)
        <tr>
            <td class="text-center">{{ $loop->iteration  }}</td>
            <td>
                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($collection->delivery_date)->translatedformat('l, d F Y') }}">
                    {{ Carbon\Carbon::parse($collection->delivery_date)->translatedformat('d M Y') }}
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
                        {{-- <a href="{{ route('collection.labelPembayaran', $collection->id) }}" class="badge bg-purple-500 me-2" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Cetak Bukti Pembayaran"><i class="fa fa-print me-0" aria-hidden="true"></i> 
                        </a> --}}
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
            <td class="accounting grandtotal">{{ number_format($collection->grandtotal) }}</td>
            <td class="text-center">
                @if ($collection->payment_status === 'Belum Lunas')
                    <span class="badge bg-warning">{{ $collection->payment_status }}</span>
                @else
                    <span class="badge bg-success">{{ $collection->payment_status }}</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot class="bg-teal-100">
        <th class="text-end">Total Pembayaran</th>
        <th class="text-start"><span class="badge bg-success">{{ number_format($order->collections->count('pay')) }} kali</span></th>
        <th class="text-end">Total</th>
        <th class="text-end"><span class="badge bg-success">Rp {{ number_format($collections->sum('pay')) }}</span></th>
        <th class="text-end"><span class="badge bg-danger">Rp {{ number_format($collections->sum('discount_rp')) }}</span></th>
        <th class="text-end">
            <span class="badge bg-danger">
                Rp {{ number_format($order->collections->sum('PPh22_rp') + $order->collections->sum('PPN_rp')) }}
            </span>
        </th>
        <th class="text-end">
            <span class="badge bg-danger">
                Rp {{ number_format($order->collections->sum('admin_fee') + $order->collections->sum('other_fee')) }}
            </span>
        </th>
        <th class="text-end"><span class="badge bg-primary">Rp {{ number_format($order->collections->sum('grandtotal')) }}</span></th>
    </tfoot>
</table>