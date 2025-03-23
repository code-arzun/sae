<h4>Riwayat Pengiriman</h4>
<table class="table bg-gray-100">
    <thead class="bg-danger">
        <th>Pengiriman ke-</th>
        <th>Tgl. DO</th>
        <th width="170px">No. DO</th>
        <th>Subtotal</th>
        <th>Terpacking</th>
        <th>Dikirim</th>
        <th>Terkirim</th>
        <th>Status</th>
    </thead>
    <tbody>
        @foreach ($deliveries as $delivery)
        <tr>
            <td class="text-center">{{ $loop->iteration  }}</td>
            <td>
                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($delivery->delivery_date)->translatedformat('l, d F Y') }}">
                    {{ Carbon\Carbon::parse($delivery->delivery_date)->translatedformat('d M Y') }}
                </span>
            </td>
            <td class="text-center">
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
                    <div class="d-flex justify-content-between align-items-center">
                        <a class="badge {{ strpos($delivery->invoice_no, '-RO') !== false ? 'bg-primary' : (strpos($delivery->invoice_no, '-HO') !== false ? 'bg-danger' : 
                            (strpos($delivery->invoice_no, '-RS') !== false ? 'bg-success' : (strpos($delivery->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))) }}" 
                            href="{{ route('do.deliveryDetails', $delivery->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Pengiriman">
                            {{ $delivery->invoice_no }}
                        </a>
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                            <a href="{{ route('do.invoiceDownload', $delivery->id) }}" class="badge bg-secondary me-2" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Cetak Dokumen DO"><i class="fa fa-print me-0" aria-hidden="true"></i> 
                            </a>
                        @endif
                    </div>
                @else
                <a class="badge {{ strpos($delivery->invoice_no, '-RO') !== false ? 'bg-primary' : (strpos($delivery->invoice_no, '-HO') !== false ? 'bg-danger' : 
                    (strpos($delivery->invoice_no, '-RS') !== false ? 'bg-success' : (strpos($delivery->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))) }}" 
                    href="{{ route('do.deliveryDetails', $delivery->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Pengiriman">
                    {{ $delivery->invoice_no }}
                </a>
                @endif
            </td>
            <td class="accounting subtotal">{{ number_format($delivery->sub_total) }}</td>
            <td class="text-center">{{ $delivery->packed_at ? Carbon\Carbon::parse($delivery->packed_at)->translatedFormat('H:i - l, d M Y') : '' }}</td>
            <td class="text-center">{{ $delivery->sent_at ? Carbon\Carbon::parse($delivery->sent_at)->translatedFormat('H:i - l, d M Y') : '' }}</td>
            <td class="text-center">{{ $delivery->delivered_at ? Carbon\Carbon::parse($delivery->delivered_at)->translatedFormat('H:i - l, d M Y') : '' }}</td>
            <td class="text-center">
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
                    @if ($delivery->delivery_status === 'Siap dikirim')
                        <a href="#" class="badge bg-danger w-100" data-bs-toggle="modal" data-bs-target="#sent{{ $delivery->id }}">{{ $delivery->delivery_status }}</a>
                        @include('warehouse.delivery.partials.modal-sent')
                    @elseif ($delivery->delivery_status === 'Dalam Pengiriman')
                        <a href="#" class="badge bg-warning w-100" data-bs-toggle="modal" data-bs-target="#delivered{{ $delivery->id }}">{{ $delivery->delivery_status }}</a>
                        @include('warehouse.delivery.partials.modal-delivered')
                    @else
                        <span class="badge bg-success w-100">{{ $delivery->delivery_status }}</span>
                    @endif
                @else
                    @if ($delivery->delivery_status === 'Siap dikirim')
                        <span class="badge bg-danger w-100">{{ $delivery->delivery_status }}</span>
                    @elseif ($delivery->delivery_status === 'Dalam Pengiriman')
                        <span class="badge bg-warning w-100">{{ $delivery->delivery_status }}</span>
                    @else
                        <span class="badge bg-success w-100">{{ $delivery->delivery_status }}</span>
                    @endif
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot class="bg-teal-100">
        <th class="text-end">Total Pengiriman</th>
        <th class="text-start"><span class="badge bg-success">{{ number_format($order->deliveries->count('sub_total')) }} kali</span></th>
        <th class="text-end">Total Subtotal</th>
        <th class="text-end"><span class="badge bg-success">Rp {{ number_format($order->deliveries->sum('sub_total')) }}</span></th>
    </tfoot>
</table>