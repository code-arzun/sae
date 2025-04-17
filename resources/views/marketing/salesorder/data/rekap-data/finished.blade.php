<!-- Rekap Selesai -->
<div class="col-md">
    @php
        $groupedByYear = $orders->where('order_status', 'Selesai')->groupBy(function($order) {
            return \Carbon\Carbon::parse($order->created_at)->year;
        });
    @endphp

    @foreach($groupedByYear as $year => $ordersByYear)
        <h4 class="mt-4">{{ $year }}</h4>
        <table class="table mb-5">
            <thead class="text-white bg-dark">
                <tr>
                    <th width="100px">Bulan</th>
                    <th width="100px">Jumlah Transaksi</th>
                    <th width="100px">Total Bruto (Subtotal)</th>
                    <th width="100px">Total Diskon</th>
                    <th width="100px">Total Netto (Grandtotal)</th>
                    <th width="100px">Total Telah dibayar</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $groupedByMonth = $ordersByYear->groupBy(function($order) {
                        return \Carbon\Carbon::parse($order->created_at)->translatedformat('F');
                    });
                @endphp

                @foreach($groupedByMonth as $month => $ordersPerMonth)
                    <tr>
                        <td><strong>{{ $month }}</strong></td>
                        <th>{{ $ordersPerMonth->count('invoice_no') }}</th>
                        <td class="accounting subtotal">{{ number_format($ordersPerMonth->sum('sub_total')) }}</td>
                        <td class="accounting discountRp">{{ number_format($ordersPerMonth->sum('discount_rp')) }}</td>
                        <td class="accounting grandtotal">{{ number_format($ordersPerMonth->sum('grandtotal')) }}</td>
                        <td class="accounting subtotal">{{ number_format($ordersPerMonth->sum('pay')) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-cyan-100">
                <tr>
                    <th>Total</th>
                    <th>{{ $ordersByYear->count('invoice_no') }}</th>
                    <td class="accounting subtotal">{{ number_format($ordersByYear->sum('sub_total')) }}</td>
                    <td class="accounting discountRp">{{ number_format($ordersByYear->sum('discount_rp')) }}</td>
                    <td class="accounting grandtotal">{{ number_format($ordersByYear->sum('grandtotal')) }}</td>
                    <td class="accounting subtotal">{{ number_format($ordersByYear->sum('pay')) }}</td>
                </tr>
            </tfoot>
        </table>
    @endforeach

    <table class="table">
        <thead class="text-white bg-dark">
            <tr>
                <th width="100px">Jumlah Transaksi</th>
                <th width="100px">Total Subtotal (Bruto)</th>
                <th width="100px">Total Diskon</th>
                <th width="100px">Total Grandtotal (Nett)</th>
                <th width="100px">Total Telah dibayar</th>
            </tr>
        </thead>
        <tfoot class="bg-white">
            <tr>
                <th>{{ $orders->where('order_status', 'Selesai')->count('invoice_no') }}</th>
                <td class="text-center accounting subtotal">{{ number_format($orders->where('order_status', 'Selesai')->sum('sub_total')) }}</td>
                <td class="text-center accounting discountRp">{{ number_format($orders->where('order_status', 'Selesai')->sum('discount_rp')) }}</td>
                <td class="text-center accounting grandtotal">{{ number_format($orders->where('order_status', 'Selesai')->sum('grandtotal')) }}</td>
                <td class="text-center accounting subtotal">{{ number_format($orders->where('order_status', 'Selesai')->sum('pay')) }}</td>
            </tr>
        </tfoot>
    </table>
</div>