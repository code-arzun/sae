<!-- Tambahkan Bootstrap JS -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('so.index') }}">Sales Order</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('so.orderDetails', $order->id) }}">Detail</a></li>
    <li class="breadcrumb-item active" aria-current="page"><b>{{ $order->invoice_no }}</b>_{{ $order->customer->NamaLembaga }}_{{ $order->customer->NamaCustomer }}_{{ $order->customer->employee->name }}</li>
@endsection

@section('action-button')
    <!-- Update status button -->
    @if ($order->order_status == 'Menunggu persetujuan')
        <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#confirmation{{ $order->id }}" data-id="{{ $order->id }}"><i class="fa fa-info-circle me-2"></i><span>Perbarui Status Sales Order</span></a>
    @endif
    @include('marketing.salesorder.data.status-update')
@endsection

@section('container')

<!-- Informasi Umum -->
<div class="mb-5">
    <h4 class="mb-3">Informasi Umum</h4>
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between">
                <div class="col d-flex flex-column mb-3">
                    <label class="mb-2">Tanggal Pemesanan</label>
                    <h5>{{Carbon\Carbon::parse($order->order_date)->translatedformat('l, d F Y') }}</h5>
                </div>
                <div class="col col-md-1 d-flex flex-column mb-3">
                    <label class="mb-2">Nomor SO</label>
                    <div>
                        <span class="badge {{ strpos($order->invoice_no, '-R') !== false ? 'bg-primary' : (strpos($order->invoice_no, '-H') !== false ? 'bg-danger' : 
                                (strpos($order->invoice_no, '-RS') !== false ? 'bg-success' : (strpos($order->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))) }}">
                            {{ $order->invoice_no }}
                        </span>
                    </div>
                </div>
                <div class="col d-flex flex-column mb-3">
                    <label class="mb-2">Metode Pembayaran</label>
                    <h5> {{ $order->payment_method }}</h5>
                </div>
                <div class="col d-flex flex-column mb-3">
                    <label class="mb-2">Status </label>
                    <div>
                        <span class="badge {{ strpos($order->order_status, 'Menunggu persetujuan') !== false ? 'bg-warning' : (strpos($order->order_status, 'Disetujui') !== false ? 'bg-success' : 
                                (strpos($order->order_status, 'Dalam pengiriman') !== false ? 'bg-success' : 'bg-secondary')) }}">
                            {{ $order->order_status }}
                        </span>
                    </div>
                </div>
                <div class="col d-flex flex-column mb-3">
                    <label class="mb-2">Nama Lembaga</label>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Customer"
                        href="{{ route('customers.show', $order->customer->id) }}">
                        <h5>{{ $order->customer->NamaLembaga }}</h5>
                    </a>
                </div>
                <div class="col d-flex flex-column mb-3">
                    <label class="mb-2">Nama Customer</label>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Customer"
                        href="{{ route('customers.show', $order->customer->id) }}">
                        <h5>{{ $order->customer->NamaCustomer }}</h5>
                    </a>
                </div>
                <div class="col col-md-1 d-flex flex-column mb-3">
                    <label class="mb-2">Jabatan</label>
                    {{-- <span class="badge bg-secondary">{{ $order->customer->Jabatan }}</span> --}}
                    <h5>{{ $order->customer->Jabatan }}</h5>
                </div>
                <div class="col d-flex flex-column">
                    <label class="mb-2">Sales</label>
                    <h5>{{ $order->customer->employee->name }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link " id="home-tab" data-bs-toggle="tab" href="#home" role="tab"><h5>Sales Order</h5></a>
        </li>
        @if ($order->order_status == 'Disetujui' || $order->order_status == 'Selesai' )
        <li class="nav-item">
            <a class="nav-link active" id="delivery-tab" data-bs-toggle="tab" href="#delivery" role="tab"><h5>Delivery Order</h5></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="collection-tab" data-bs-toggle="tab" href="#coll" role="tab"><h5>Collection</h5></a>
        </li>
        @endif
    </ul>
    <!-- Content -->
    <div class="tab-content" id="myTabContent">
        <!-- Sales Order -->
        <div class="tab-pane fade " id="home" role="tabpanel">
            @include('marketing.salesorder.details.so')
        </div>
        <!-- Delivery Order -->
        <div class="tab-pane fade show active" id="delivery" role="tabpanel">
            @include('marketing.salesorder.details.do')
        </div>
        <!-- Collection -->
        <div class="tab-pane fade" id="coll" role="tabpanel">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Collection</h4>
                    </div>
                </div>
                <div class="dt-responsive table-responsive">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>Subtotal</th>
                                <th>Diskon</th>
                                <th>Grand Total</th>
                                <th>Total Tagihan</th>
                                <th>Tagihan</th>
                                <th>Telah dibayar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-success">Rp {{ number_format($order->sub_total) }}</td>
                                <td><span class="badge bg-warning">{{ number_format($order->discount_percent, 2) }}%</span> <span class="badge bg-danger">Rp {{ number_format($order->discount_rp) }}</span></td>
                                <td><span class="badge bg-primary">Rp {{ number_format($order->grandtotal) }}</td>
                                <td><span class="badge bg-purple">Rp {{ number_format($order->sub_total) }}</td>
                                <td><span class="badge bg-danger">Rp {{ number_format($order->due) }}</td>
                                <td><span class="badge bg-success">Rp {{ number_format($order->pay) }}</td>
                                <td class="text-center">
                                    @if ($order->payment_status === 'Lunas')
                                        <span class="badge bg-success">{{ $order->payment_status }}</span>
                                    @elseif ($order->payment_status === 'Belum Lunas')
                                        <span class="badge bg-warning">{{ $order->payment_status }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $order->payment_status }}</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="dt-responsive table-responsive">
                    <table class="table table-striped table-bordered nowrap mb-3">
                        <thead>
                            <tr>
                                <th>Pembayaran ke-</th>
                                <th>Tanggal Coll</th>
                                <th>No. Coll</th>
                                <th>Dokumen</th>
                                <th>Dibayarkan</th>
                                <th>Nett</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($collections as $collection)
                            <tr class="text-center">
                                <td>{{ $loop->iteration  }}</td>
                                <td>{{ Carbon\Carbon::parse($collection->collection_date)->translatedformat('l, d F Y') }}</td>
                                <td>
                                    <a class="badge badge-primary" href="{{ route('collection.details', $collection->id) }}" 
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">{{ $collection->invoice_no }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('collection.invoiceDownload', $collection->id) }}"
                                        class="btn bg-warning me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Dokumen">
                                        <i class="fa fa-print me-0" aria-hidden="true"></i> 
                                    </a>
                                </td>
                                <td class="text-end">Rp {{ number_format($collection->pay) }}</td>
                                <td class="text-end">Rp {{ number_format($collection->grandtotal) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>

@include('components.preview-img-form')
@endsection