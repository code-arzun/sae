@extends('layout.main')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><a href="{{ route('cashflow.index') }}">Arus Kas</a></li>
@endsection

@section('action-button')
    <!-- 
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahTransaksi"><i class="ti ti-plus"></i> Catat Transaksi Baru</button>
        {{-- @include('finance.cashflow.create') --}}
    -->
    <a href="{{ route('cashflowcategory.index') }}" class="btn btn-primary me-3">Kategori Transaksi</a>
    <!-- Create Income -->
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createIncome">Catat Pemasukan Baru</button>
    @include('finance.cashflow.create-income')
    <!-- Create Expenditure -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createExpenditure">Catat Pengeluaran Baru</button>
    @include('finance.cashflow.create-expenditure')
@endsection

@section('container')

@if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Finance', 'Manajer Marketing']))
<ul class="nav nav-tabs mb-3" id="cashflow" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"><h5><i class="ti ti-table me-2"></i>Buku Kas</h5></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="annual-tab" data-bs-toggle="tab" href="#annual" role="tab"><h5><i class="ti ti-table me-2"></i>Rekap Tahunan</h5></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="monthly-tab" data-bs-toggle="tab" href="#monthly" role="tab"><h5><i class="ti ti-table me-2"></i>Rekap Bulanan</h5></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="download-tab" data-bs-toggle="tab" href="#download" role="tab"><h5><i class="ti ti-download me-2"></i>Download</h5></a>
    </li>
</ul>
@endif

<div class="tab-content" id="cashflowContent">
    <!-- All Data -->
    <div class="tab-pane fade show active" id="all" role="tabpanel">
        @include('finance.cashflow.data.table')
    </div>
    <!-- Annual Data -->
    <div class="tab-pane fade" id="annual" role="tabpanel">
        @include('finance.cashflow.data.table-annual', ['cashflows' => $cashflows])
    </div>
    <!-- Data monthly -->
    <div class="tab-pane fade" id="monthly" role="tabpanel">
        @include('finance.cashflow.data.table-monthly', ['cashflows' => $cashflows])
    </div>
    
</div>

@endsection
