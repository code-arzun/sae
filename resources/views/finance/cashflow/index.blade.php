@extends('layout.main')

@section('container')

<div class="d-flex justify-content-between mb-3">
    <div>
        <h2>{{ $title }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-default-icon">
                @include('finance.cashflow.category.partials.breadcrumb')
            </ol>
        </nav>
    </div>
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahTransaksi"><i class="ti ti-plus"></i> Catat Transaksi Baru</button>
        <!-- Create -->
        @include('finance.cashflow.create')
    </div>
</div>

@if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Finance', 'Manajer Marketing']))
<ul class="nav nav-tabs mb-3" id="cashflow" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"><h5><i class="ti ti-table me-2"></i>Buku Kas</h5></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="recap-tab" data-bs-toggle="tab" href="#recap" role="tab"><h5><i class="ti ti-table me-2"></i>Rekap</h5></a>
    </li>
</ul>
@endif

<div class="tab-content" id="cashflowContent">
    <!-- All Data -->
    <div class="tab-pane fade show active" id="all" role="tabpanel">
        @include('finance.cashflow.data.table')
    </div>
    <!-- Data Recap -->
    <div class="tab-pane fade" id="recap" role="tabpanel">
        {{-- @include('finance.cashflow.data.bukukas') --}}
    </div>
</div>

@endsection
