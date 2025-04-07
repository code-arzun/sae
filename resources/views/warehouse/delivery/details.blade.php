@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('do.index') }}">Delivery Order</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('do.deliveryDetails', $delivery->id) }}">Detail</a></li>
    <li class="breadcrumb-item active" aria-current="page"><b>{{ $delivery->invoice_no }}</b>
@endsection

@section('action-button')
    @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
        @if ($delivery->delivery_status === 'Siap dikirim')
            <a href="#" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#sent{{ $delivery->id }}" data-id="{{ $delivery->id }}"><i class="fa fa-info-circle me-2"></i>Perbarui Status Pengiriman</a>
            @include('warehouse.delivery.partials.modal-sent')
        @elseif ($delivery->delivery_status === 'Dalam Pengiriman')
            <a href="#" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#delivered{{ $delivery->id }}" data-id="{{ $delivery->id }}"><i class="fa fa-info-circle me-2"></i>Perbarui Status Pengiriman</a>
            @include('warehouse.delivery.partials.modal-delivered')
        @endif
    @endif
@endsection

@section('container')

<div class="mb-3">
    <h4>Sales Order</h4>
    <div class="card">
        <div class="card-body row">
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Tanggal SO</label>
                <h5>{{Carbon\Carbon::parse($delivery->salesorder->order_date)->translatedformat('l, d F Y') }}</h5>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Nomor SO</label>
                <div>
                    <a href="{{ route('so.orderDetails', $delivery->salesorder->id) }}" class="badge {{ strpos($delivery->salesorder->invoice_no, '-R') !== false ? 'bg-primary' : (strpos($delivery->salesorder->invoice_no, '-H') !== false ? 'bg-danger' : 
                            (strpos($delivery->salesorder->invoice_no, '-RS') !== false ? 'bg-success' : (strpos($delivery->salesorder->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))) }}">
                        {{ $delivery->salesorder->invoice_no }}
                    </a>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Nama Lembaga</label>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Customer"
                    href="{{ route('customers.show', $delivery->salesorder->customer->id) }}">
                    <h5>{{ $delivery->salesorder->customer->NamaLembaga }}</h5>
                </a>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Nama Customer</label>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Customer"
                    href="{{ route('customers.show', $delivery->salesorder->customer->id) }}">
                    <h5>{{ $delivery->salesorder->customer->NamaCustomer }}</h5>
                </a>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Jabatan</label>
                <div>
                    <span class="badge bg-secondary">{{ $delivery->salesorder->customer->Jabatan }}</span>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Sales</label>
                <h5>{{ $delivery->salesorder->customer->employee->name }}</h5>
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <h4>Detail Delivery Order</h4>
    <div class="card">
        <div class="card-body row">
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Tanggal DO</label>
                <h5>{{Carbon\Carbon::parse($delivery->delivery_date)->translatedformat('l, d F Y') }}</h5>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Nomor DO</label>
                <div>
                    <span class="badge {{ strpos($delivery->invoice_no, '-R') !== false ? 'bg-primary' : (strpos($delivery->invoice_no, '-H') !== false ? 'bg-danger' : 
                            (strpos($delivery->invoice_no, '-RS') !== false ? 'bg-success' : (strpos($delivery->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))) }}">
                        {{ $delivery->invoice_no }}
                    </span>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Pengiriman</label>
                <div class="d-flex">
                    ke-<h5>{{ $delivery->delivery_order }}</h5>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Status Pengiriman</label>
                <div>
                    <span class="badge {{ strpos($delivery->delivery_status, 'Siap dikirim') !== false ? 'bg-danger' : (strpos($delivery->delivery_status, 'Dalam Pengiriman') !== false ? 'bg-warning' : 'bg-success') }}">
                        {{ $delivery->delivery_status }}
                    </span>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Diinput pada</label>
                <h5>{{ $delivery->created_at ? Carbon\Carbon::parse($delivery->created_at)->translatedFormat('H:i - d M Y') : '' }}</h5>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Diperbarui pada</label>
                <h5>{{ $delivery->updated_at ? Carbon\Carbon::parse($delivery->updated_at)->translatedFormat('H:i - d M Y') : '' }}</h5>
            </div>

@php
    $steps = [
        ['label' => 'Terpacking', 'icon' => 'ti ti-box f-30', 'key' => 'packed_at'],
        ['label' => 'Dikirim', 'icon' => 'fas fa-truck f-20', 'key' => 'sent_at'],
        ['label' => 'Terkirim', 'icon' => 'ti ti-check f-30', 'key' => 'delivered_at'],
    ];

    // Status yang aktif
    $statuses = [
        'Siap dikirim' => 1,
        'Dalam Pengiriman' => 2,
        'Terkirim' => 3,
    ];

    $currentStep = $statuses[$delivery->delivery_status] ?? 0;
    $progressWidth = ($currentStep - 1) * 50;
@endphp

<div class="p-3 p-sm-5">
    <div class="position-relative">
        <div class="progress" style="height: 3px">
            @if ($currentStep > 1)
                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progressWidth }}%" aria-valuenow="{{ $progressWidth }}" aria-valuemin="0" aria-valuemax="100"></div>
            @endif
        </div>
        @foreach ($steps as $index => $step)
            @php
                $stepIndex = $index + 1;
                $iconColor = $stepIndex <= $currentStep ? 'bg-primary' : 'bg-secondary';
                $positionClass = match ($stepIndex) {
                    1 => 'start-0',
                    2 => 'start-50',
                    3 => 'start-100',
                };
            @endphp
            <div class="avtar avtar-s rounded-circle text-white {{ $iconColor }} position-absolute top-0 {{ $positionClass }} translate-middle" style="width: 3rem; height: 3rem">
                <i class="{{ $step['icon'] }}"></i>
            </div>
        @endforeach
    </div>
</div>

<div class="d-flex justify-content-between">
    @foreach ($steps as $step)
        <div class="mb-3">
            <label class="mb-1 d-block">{{ $step['label'] }}</label>
            <h5>
                @if (!empty($delivery->{$step['key']}))
                    {{ \Carbon\Carbon::parse($delivery->{$step['key']})->translatedFormat('H:i - l, d F Y') }}
                @else
                    <span class="text-muted">-</span>
                @endif
            </h5>
        </div>
    @endforeach
</div>

        </div>
    </div>
</div>

@if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
<a href="{{ route('do.invoiceDownload', $delivery->id) }}"
    class="btn btn-primary mb-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Dokumen DO">
    <i class="fa fa-print me-2" aria-hidden="true"></i> Dokumen DO
</a>
@endif

@include('warehouse.delivery.details.table')


@include('components.preview-img-form')
@endsection
