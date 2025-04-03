@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('so.index') }}">Sales Order</a></li>
@endsection

@section('action-button')
    @if (auth()->user()->hasAnyRole('Super Admin', 'Admin', 'Sales', 'Manajer Marketing'))
        <a href="{{ route('input.so') }}" class="btn btn-primary">Buat SO</a>
        @endif
        @if (auth()->user()->hasAnyRole('Super Admin', 'Admin', 'Admin Gudang', 'Manajer Marketing'))
        <a href="{{ route('so.exportData') }}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Excel">
            <i class="fa fa-file-excel me-2"></i>
            Download Excel
        </a>
    @endif
@endsection

@section('container')

<ul class="nav nav-tabs mb-3" id="salesorder" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"><h5><i class="ti ti-table me-2"></i>Data</h5></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="datarecap-tab" data-bs-toggle="tab" href="#datarecap" role="tab"><h5><i class="ti ti-table me-2"></i>Rekap Data</h5></a>
    </li>
</ul>
<div class="tab-content" id="salesorderContent">
    <!-- All Data -->
    <div class="tab-pane fade show active" id="all" role="tabpanel">
        @include('marketing.salesorder.partials.table')
    </div>
    <!-- Data Recap -->
    <div class="tab-pane fade" id="datarecap" role="tabpanel">
        @include('marketing.salesorder.data.recap')
    </div>
</div>

@endsection
