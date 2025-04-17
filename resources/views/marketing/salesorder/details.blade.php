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
    @if ($order->order_status == 'Menunggu persetujuan' & (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin'])))
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
    <ul class="nav nav-tabs mb-3" id="details" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="salesorder-tab" data-bs-toggle="tab" href="#salesorder" role="tab"><h5>Sales Order</h5></a>
        </li>
        @if ($order->order_status == 'Disetujui' || $order->order_status == 'Selesai' )
        <li class="nav-item">
            <a class="nav-link" id="delivery-tab" data-bs-toggle="tab" href="#delivery" role="tab"><h5>Delivery Order</h5></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="collection-tab" data-bs-toggle="tab" href="#coll" role="tab"><h5>Collection</h5></a>
        </li>
        @endif
    </ul>
    <!-- Content -->
    <div class="tab-content" id="detailsContent">
        <!-- Sales Order -->
        <div class="tab-pane fade show active" id="salesorder" role="tabpanel">
            @include('marketing.salesorder.details.so')
        </div>
        <!-- Delivery Order -->
        <div class="tab-pane fade" id="delivery" role="tabpanel">
            @include('marketing.salesorder.details.do')
        </div>
        <!-- Collection -->
        <div class="tab-pane fade" id="coll" role="tabpanel">
            @include('marketing.salesorder.details.coll')
        </div>
    </div>
</div>

@include('components.preview-img-form')
@endsection