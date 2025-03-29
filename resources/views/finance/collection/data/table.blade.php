<table class="table table-hover bg-white nowrap mb-3">
    <thead>
        <tr>
            <!-- Partial Head -->
            @include('layout.table.so-head')
            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
            <th width="50px"><i class="ti ti-file-alert"></i></th>
            @endif
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
                        <a class="badge bg-purple-300 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Dokumen Penyiapan Produk" data-original-title="Cetak Dokumen Penyiapan Produk"
                            href="{{ route('do.printPenyiapan', $order->id) }}">
                            <i class="fa fa-print me-0" aria-hidden="true"></i>
                        </a>
                        <!-- Shipping Update -->
                        {{-- @include('layout.partials.shipping-update') --}}
                    </div>
                </td>
            @endif
            @if ($order->payment_status === 'Belum dibayar')
                <td colspan="2"><a class="badge bg-danger w-100" data-bs-toggle="collapse" href="#detailsColl{{ $order->id }}" aria-expanded="false" aria-controls="detailsColl{{ $order->id }}">Belum ada Pembayaran</a></td>
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

{{-- <div class="col-lg-12">
    <div class="dt-responsive table-responsive mb-3">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tgl. SO</th>
                    <th>No. SO</th>
                    <th> 'Customer</th>
                    @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                    <th> 'Sales</th>
                    @endif
                    <th>Bruto</th>
                    <th>Netto</th>
                    <th>Tagihan</th>
                    <th>Dibayar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesorders as $salesorder)
                <tr>
                    <td>{{ $loop->iteration  }}</td>
                    <td>
                        <a class="badge badge-primary" href="{{ route('so.orderDetails', $salesorder->id) }}" 
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">{{ $salesorder->invoice_no }}
                        </a>
                    </td>
                    <td>
                        <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($salesorder->order_date)->translatedformat('l, d F Y') }}">
                            {{ Carbon\Carbon::parse($salesorder->order_date)->translatedformat('d M Y') }}
                        </span>
                    </td>
                    <td>
                        <h6>{{ $salesorder->customer->NamaLembaga }}</h6>
                            {{ $salesorder->customer->NamaCustomer }}
                    </td>
                    @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                    <td>{{ $salesorder->customer->employee->name }}</td>
                    @endif
                    <td class="text-end"><span class="badge bg-success">Rp {{ number_format($salesorder->sub_total) }}</span></td>
                    <td class="text-end"><span class="badge bg-warning">Rp {{ number_format($salesorder->grandtotal) }}</span></td>
                    <td class="text-end">
                        @if ($salesorder->due > 0)
                                <span class="badge bg-danger">Rp {{ number_format($salesorder->due) }}</span>
                            @else
                        @endif
                    </td>
                    <td class="text-end">
                        @if ($salesorder->pay > 0)
                                <span class="badge bg-primary">Rp {{ number_format($salesorder->pay) }}</span>
                            @else
                        @endif
                    </td>
                    <td>
                        @if ($salesorder->payment_status === 'Belum dibayar')
                            <span class="badge bg-danger">{{ $salesorder->payment_status }}</span>
                        @elseif ($salesorder->payment_status === 'Belum Lunas')
                            <span class="badge bg-warning">{{ $salesorder->payment_status }}</span>
                        @else
                            <span class="badge bg-success">{{ $salesorder->payment_status }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $salesorders->links() }}
</div> --}}