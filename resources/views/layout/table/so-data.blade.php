<th>{{ $loop->iteration }}</th>
<td>
    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($order->order_date)->translatedformat('l, d F Y') }}">
        {{ Carbon\Carbon::parse($order->order_date)->translatedformat('d M Y') }}
    </span>
</td>
<td>
    <div class="d-flex justify-content-between align-items-center">
        <a class="badge me-2
            {{ 
                // $order->order_status === 'Menunggu persetujuan' ? 'bg-purple' : 
                (strpos($order->invoice_no, '-RO') !== false ? 'bg-primary' : 
                (strpos($order->invoice_no, '-HO') !== false ? 'bg-danger' : 
                (strpos($order->invoice_no, '-RS') !== false ? 'bg-success' : 
                (strpos($order->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary')))) }}"  
                href="{{ route('so.orderDetails', $order->id) }}" 
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                title="Lihat Detail Pesanan">
                {{ $order->invoice_no }}
        </a>
        <a href="{{ route('so.invoiceDownload', $order->id) }}"
            class="badge bg-info"  data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak dokumen SO">
            <i class="fas fa-print" aria-hidden="true"></i> 
        </a>
    </div>
</td>
<td>
    <h6 class="mb-0">{{ $order->customer->NamaLembaga }}</h6>
    <span class="text-secondary">{{ $order->customer->NamaCustomer }}</span>
</td>
@if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
<th data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $order->customer->employee->name }}">{{ explode(' ', $order->customer->employee->name)[0] }}</th>
@endif
<td class="accounting subtotal">{{ number_format($order->sub_total) }}</td>
@if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Sales']))
<td class="accounting discountPercent">{{ number_format($order->discount_percent, 2) }}</td>
<td class="accounting discountRp">{{ number_format($order->discount_rp) }}</td>
<td class="accounting grandtotal">{{ number_format($order->grandtotal) }}</td>
<!-- Status SO -->
{{-- <td class="text-center">
    @if ((auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']) && $order->order_status === 'Disetujui' && $order->shipping_status === 'Terkirim' && $order->payment_status === 'Lunas'))
        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Perbarui status menjadi SELESAI">
            <a href="#" class="badge bg-info w-100" data-bs-toggle="modal" data-bs-target="#finished{{ $order->id }}" data-id="{{ $order->id }}">Disetujui</a>
        </span>
        <!-- modal -->
        @include('marketing.salesorder.data.status-finished')
    @else 
        <span data-bs-toggle="tooltip" class="badge bg-primary w-100">{{ $order->order_status }}</span>
    @endif
</td> --}}
@endif