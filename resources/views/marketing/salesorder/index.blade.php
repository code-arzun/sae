@extends('layout.main')

@section('container')

<div class="d-flex justify-content-between mb-3">
    <div>
        <h2>Data Sales Order</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-default-icon">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti ti-home-2"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('so.index') }}">Sales Order</a></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('input.so') }}" class="btn btn-primary">Buat SO</a>
        @if (auth()->user()->hasAnyRole('Super Admin', 'Admin', 'Admin Gudang', 'Manajer Marketing'))
        <a href="{{ route('so.exportData') }}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Excel">
            <!-- <i class="fa fa-file-excel"></i> -->
            Download Excel
        </a>
        @endif
    </div>
</div>

<ul class="nav nav-tabs mb-3" id="salesorder" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"><h5><i class="ti ti-table me-2"></i>Semua</h5></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="proposed-tab" data-bs-toggle="tab" href="#proposed" role="tab"><h5><i class="ti ti-table me-2"></i>Menunggu Persetujuan</h5></a>
        {{-- <a class="nav-link" id="proposed-tab" data-bs-toggle="tab" href="{{ route('so.proposed') }}" role="tab"><h5><i class="ti ti-table me-2"></i>Menunggu Persetujuan</h5></a> --}}
    </li>
    <li class="nav-item">
        <a class="nav-link" id="approved-tab" data-bs-toggle="tab" href="#approved" role="tab"><h5><i class="ti ti-table me-2"></i>Disetujui</h5></a>
    </li>
</ul>
<div class="tab-content" id="salesorderContent">
    <!-- All -->
    @include('marketing.salesorder.partials.all')
    <!-- Proposed -->
    @include('marketing.salesorder.partials.proposed')
    <!-- Approved -->
    @include('marketing.salesorder.partials.approved')
</div>
@endsection
