@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('do.index') }}">Delivery Order</a></li>
@endsection

@section('action-button')
    @if (auth()->user()->hasAnyRole('Super Admin', 'Admin', 'Admin Gudang', 'Manajer Marketing'))
        <a href="{{ route('do.exportData') }}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Excel">
            <i class="fa fa-file-excel me-2"></i>
            Download Excel
        </a>
    @endif
@endsection

@section('container')

<ul class="nav nav-tabs mb-3" id="delivery" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"><h5><i class="ti ti-table me-2"></i>Data</h5></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="datarecap-tab" data-bs-toggle="tab" href="#datarecap" role="tab"><h5><i class="ti ti-table me-2"></i>Rekap Data</h5></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="chart-tab" data-bs-toggle="tab" href="#chart" role="tab"><h5><i class="ti ti-table me-2"></i>Chart</h5></a>
    </li>
</ul>
<div class="tab-content" id="deliveryContent">
    <!-- All Data -->
    <div class="tab-pane fade show active" id="all" role="tabpanel">
        @include('warehouse.delivery.data.table')
    </div>
    <!-- Data Recap -->
    <div class="tab-pane fade" id="datarecap" role="tabpanel">
        @include('warehouse.delivery.data.recap')
    </div>
    <!-- Data Recap -->
    <div class="tab-pane fade" id="chart" role="tabpanel">
        @include('warehouse.delivery.data.chart')
    </div>
</div>

@endsection
