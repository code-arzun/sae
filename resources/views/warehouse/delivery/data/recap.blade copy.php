<table class="table mb-0">
    <thead class="badge-white text-uppercase">
        <tr>
            <th>Jumlah Transaksi</th>
            <th>Terpacking</th>
            <th>Dalam Pengiriman</th>
            <th>Terkirim</th>
            <th>Total Subtotal (Bruto)</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <tr>
            <td>{{ $deliveries->count('sub_total') }}</td>
            <td>
                <span class="btn badge-info text-white">
                    {{ $deliveries->whereNotNull('packed_at')->whereNull('sent_at')->whereNull('delivered_at')->count() }}
                </span>
            </td>
            <td>
                <span class="btn badge-warning text-white">
                    {{ $deliveries->whereNotNull('sent_at')->whereNull('delivered_at')->count() }}
                </span>
            </td>
            <td>
                <span class="btn badge-success text-white">
                    {{ $deliveries->whereNotNull('delivered_at')->count() }}
                </span>
            </td>
            <td>
                <span class="btn badge-warning text-white">
                   Rp {{ number_format($deliveries->sum('sub_total')) }}
                </span>
            </td>
        </tr>
    </tbody>
</table>