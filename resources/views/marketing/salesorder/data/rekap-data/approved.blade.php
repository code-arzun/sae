<!-- Rekap Disetujui -->
{{-- <div class="col-md-2">
    <div class="card">
        <div class="card-body d-flex justify-content-between">
            <div>
                <h5>Total Transaksi</h5>
                <span class="badge bg-primary">Disetujui</span>
            </div>
            <div>
                <h1 class="text-primary">{{ $orders->where('order_status', 'Disetujui')->count('invoice_no') }}</h1>
            </div>
        </div>
    </div>
</div>
<div class="col-md-10">
    <table class="table">
        <thead class="text-center text-white">
            <tr>
                <th>Total Subtotal (Bruto)</th>
                <th>Total Diskon</th>
                <th>Total Grandtotal (Nett)</th>
                <th>Total Telah dibayar</th>
                <th>Total Diskon</th>
                <th>Total Biaya-biaya & Diskon</th>
                <th>Total Diterima</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr>
                <td>
                    <span class="badge bg-success text-white">
                    Rp {{ number_format($orders->where('order_status', 'Disetujui')->sum('sub_total')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-danger text-white">
                    Rp {{ number_format($orders->where('order_status', 'Disetujui')->sum('discount_rp')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-success text-white">
                    Rp {{ number_format($orders->where('order_status', 'Disetujui')->sum('grandtotal')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-success text-white">
                    Rp {{ number_format($orders->where('order_status', 'Disetujui')->sum('pay')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-warning text-white">
                    Rp {{ number_format($collections->sum('discount_rp')) }}
                    </span>
                </td>
                <td>
                    ?
                </td>
                <td>
                    ?
                </td>
            </tr>
        </tbody>
    </table>
</div> --}}

<div class="col-md-12">
    @php
    $groupedByYear = $orders->where('order_status', 'Disetujui')->groupBy(function($order) {
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
                <th width="100px">Total Tagihan</th>
                <th width="100px">Total Telah dibayar</th>
                <th width="100px">Total Belum dibayar</th>
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
                    <td class="accounting discountRp">{{ number_format($ordersPerMonth->sum('sub_total')) }}</td>
                    <td class="accounting subtotal">{{ number_format($ordersPerMonth->sum('pay')) }}</td>
                    <td class="accounting discountRp">{{ number_format($ordersPerMonth->sum('due')) }}</td>
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
                <td class="accounting discountRp">{{ number_format($ordersByYear->sum('sub_total')) }}</td>
                <td class="accounting subtotal">{{ number_format($ordersByYear->sum('pay')) }}</td>
                <td class="accounting discountRp">{{ number_format($ordersByYear->sum('due')) }}</td>
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
            <th width="100px">Total Tagihan</th>
            <th width="100px">Total Telah dibayar</th>
            <th width="100px">Total Belum dibayar</th>
        </tr>
    </thead>
    <tfoot class="bg-white">
        <tr>
            <th>{{ $orders->where('order_status', 'Disetujui')->count('invoice_no') }}</th>
            <td class="text-center accounting subtotal">{{ number_format($orders->where('order_status', 'Disetujui')->sum('sub_total')) }}</td>
            <td class="text-center accounting discountRp">{{ number_format($orders->where('order_status', 'Disetujui')->sum('discount_rp')) }}</td>
            <td class="text-center accounting grandtotal">{{ number_format($orders->where('order_status', 'Disetujui')->sum('grandtotal')) }}</td>
            <td class="text-center accounting discountRp">{{ number_format($orders->where('order_status', 'Disetujui')->sum('sub_total')) }}</td>
            <td class="text-center accounting subtotal">{{ number_format($orders->where('order_status', 'Disetujui')->sum('pay')) }}</td>
            <td class="text-center accounting discountRp">{{ number_format($orders->where('order_status', 'Disetujui')->sum('due')) }}</td>
        </tr>
    </tfoot>
</table>
</div>