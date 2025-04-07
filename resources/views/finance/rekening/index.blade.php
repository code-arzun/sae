@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rekening.index') }}">{{ $title }}</a></li>
@endsection

@section('action-button')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRekening">Tambah {{ $title }} Baru</button>
    @include('finance.rekening.create')
@endsection

@section('container')
@if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Finance', 'Manajer Marketing']))
<ul class="nav nav-tabs mb-3" id="rekening" role="tablist">
    <li class="nav-item">
        <a class="nav-link" id="bank-tab" data-bs-toggle="tab" href="#bank" role="tab"><h5><i class="ti ti-table me-2"></i>Bank</h5></a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" id="rekeningData-tab" data-bs-toggle="tab" href="#rekeningData" role="tab"><h5><i class="ti ti-table me-2"></i>{{ $title }}</h5></a>
    </li>
</ul>
@endif

<div class="tab-content" id="rekeningContent">
    <!-- bank Data -->
    <div class="tab-pane fade" id="bank" role="tabpanel">
        @include('finance.bank.index')
    </div>
    <!-- Rekening Data -->
    <div class="tab-pane fade show active" id="rekeningData" role="tabpanel">
        @include('finance.rekening.data')
    </div>
</div>

@endsection
