<!-- Rekap Total -->
<div class="col-md-12 mb-5">
    @php
        $groupedByYear = $deliveries->groupBy(function($delivery) {
            return \Carbon\Carbon::parse($delivery->created_at)->year;
        });
    @endphp

    @foreach($groupedByYear as $year => $deliveriesByYear)
        <h4 class="mt-4">{{ $year }}</h4>
        <table class="table mb-5">
            <thead class="text-white bg-dark">
                <tr>
                    <th width="100px">Bulan</th>
                    <th width="200px">Jumlah Transaksi</th>
                    <th width="200px">Total Bruto (Subtotal)</th>
                    <th colspan="2" class="bg-danger">Siap Dikirim</th>
                    <th colspan="2" class="bg-warning">Dalam Pengiriman</th>
                    <th colspan="2" class="bg-success">Terkirim</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $groupedByMonth = $deliveriesByYear->groupBy(function($delivery) {
                        return \Carbon\Carbon::parse($delivery->created_at)->translatedformat('F');
                    });
                @endphp

                @foreach($groupedByMonth as $month => $deliveriesPerMonth)
                    <tr>
                        <td><strong>{{ $month }}</strong></td>
                        <th>{{ $deliveriesPerMonth->count('invoice_no') }}</th>
                        <td class="accounting subtotal">{{ number_format($deliveriesPerMonth->sum('sub_total')) }}</td>
                        <th width="50px" class="">{{ number_format($deliveriesPerMonth->whereNotNull('packed_at')->whereNull('sent_at')->whereNull('delivered_at')->count()) }}</th>
                        <th width="150px" class="accounting price">{{ number_format($deliveriesPerMonth->whereNotNull('packed_at')->whereNull('sent_at')->whereNull('delivered_at')->sum('sub_total')) }}</th>
                        <th width="50px" class="">{{ number_format($deliveriesPerMonth->whereNotNull('sent_at')->whereNull('delivered_at')->count()) }}</th>
                        <th width="150px" class="accounting price">{{ number_format($deliveriesPerMonth->whereNotNull('sent_at')->whereNull('delivered_at')->sum('sub_total')) }}</th>
                        <th width="50px" class="">{{ number_format($deliveriesPerMonth->whereNotNull('delivered_at')->count()) }}</th>
                        <th width="150px" class="accounting price">{{ number_format($deliveriesPerMonth->whereNotNull('delivered_at')->sum('sub_total')) }}</th>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-cyan-100">
                <tr>
                    <th>Total</th>
                    <th>{{ $deliveriesByYear->count('invoice_no') }}</th>
                    <td class="accounting subtotal">{{ number_format($deliveriesByYear->sum('sub_total')) }}</td>
                    <th width="50px" class="">{{ number_format($deliveriesByYear->whereNotNull('packed_at')->whereNull('sent_at')->whereNull('delivered_at')->count()) }}</th>
                    <th width="100px" class="accounting price">{{ number_format($deliveriesByYear->whereNotNull('packed_at')->whereNull('sent_at')->whereNull('delivered_at')->sum('sub_total')) }}</th>
                    <th width="50px" class="">{{ number_format($deliveriesByYear->whereNotNull('sent_at')->whereNull('delivered_at')->count()) }}</th>
                    <th width="100px" class="accounting price">{{ number_format($deliveriesByYear->whereNotNull('sent_at')->whereNull('delivered_at')->sum('sub_total')) }}</th>
                    <th width="50px" class="">{{ number_format($deliveriesByYear->whereNotNull('delivered_at')->count()) }}</th>
                    <th width="100px" class="accounting price">{{ number_format($deliveriesByYear->whereNotNull('delivered_at')->sum('sub_total')) }}</th>
                </tr>
            </tfoot>
        </table>
    @endforeach

    <table class="table">
        <thead class="text-white bg-dark">
            <tr>
                <th width="100px">Jumlah Transaksi</th>
                <th width="100px">Total Subtotal (Bruto)</th>
                <th colspan="2" class="bg-danger">Siap Dikirim</th>
                <th colspan="2" class="bg-warning">Dalam Pengiriman</th>
                <th colspan="2" class="bg-success">Terkirim</th>
            </tr>
        </thead>
        <tfoot class="bg-white">
            <tr>
                <th>{{ $deliveries->count('invoice_no') }}</th>
                <td class="text-center accounting subtotal">{{ number_format($deliveries->sum('sub_total')) }}</td>
                <th width="50px" class="">{{ number_format($deliveriesByYear->whereNotNull('packed_at')->whereNull('sent_at')->whereNull('delivered_at')->count()) }}</th>
                <th width="100px" class="accounting price">{{ number_format($deliveriesByYear->whereNotNull('packed_at')->whereNull('sent_at')->whereNull('delivered_at')->sum('sub_total')) }}</th>
                <th width="50px" class="">{{ number_format($deliveriesByYear->whereNotNull('sent_at')->whereNull('delivered_at')->count()) }}</th>
                <th width="100px" class="accounting price">{{ number_format($deliveriesByYear->whereNotNull('sent_at')->whereNull('delivered_at')->sum('sub_total')) }}</th>
                <th width="50px" class="">{{ number_format($deliveriesByYear->whereNotNull('delivered_at')->count()) }}</th>
                <th width="100px" class="accounting price">{{ number_format($deliveriesByYear->whereNotNull('delivered_at')->sum('sub_total')) }}</th>
            </tr>
        </tfoot>
    </table>
</div>