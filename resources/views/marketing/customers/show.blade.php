@extends('layout.main')

@section('container')

<div class="d-flex justify-content-between mb-3">
    <div>
        <h2>{{ $title }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-default-icon">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti ti-home-2"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Data Customer</a></li>
                {{-- <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('customers.show', $customer->id) }}">Detail Customer</a></li> --}}
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('customers.show', $customer->id) }}">{{ $customer->NamaLembaga }}_{{ $customer->NamaCustomer }}
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                        _{{ $customer->employee->name }}
                        @endif
                    </a>
                </li>
                {{-- <li class="breadcrumb-item">{{ $customer->NamaLembaga }}_{{ $customer->NamaCustomer }}_{{ $customer->employee->name }}</li> --}}
            </ol>
        </nav>
    </div>
    <div>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCustomer{{ $customer->id }}"><i class="ti ti-edit"></i></button>
        @include('marketing.customers.edit')
    </div>
</div>

<div class="row mb-3">
    <div class="col-lg-12 mb-3">
        <h4>Sales</h4>
        <input type="text" class="form-control bg-white text-strong" value="{{ $customer->employee->name }}" readonly>
    </div>
    
    <div class="col-lg-6">
        <h4>Data Lembaga</h4>
        <div class="card">
            <div class="card-body row">
                <div class="form-group col-md">
                    <label class="text-muted mb-1">Nama Lembaga</label>
                    {{-- <input type="text" class="form-control bg-white text-strong" value="{{ $customer->NamaLembaga }}" readonly> --}}
                    <h5>{{ $customer->NamaLembaga }}</h5>
                </div>
                <div class="form-group col-md-2">
                    <label class="text-muted mb-1">Potensi</label> <br>
                    <span class="badge
                    {{ strpos($customer->Potensi, 'Tinggi') !== false ? 'bg-success' : 
                        (strpos($customer->Potensi, 'Sedang') !== false ? 'bg-warning' : 
                        (strpos($customer->Potensi, 'Rendah') !== false ? 'bg-danger' : 'bg-primary')) }}">
                    {{ $customer->Potensi }}</span>
                    {{-- <input type="text" class="form-control bg-white" value="{{ $customer->Potensi }}" readonly> --}}
                </div>
                <div class="form-group col-md-12">
                    <label class="text-muted mb-1">Alamat</label>
                    {{-- <textarea rows="3" class="form-control bg-white text-strong" readonly>{{ $customer->AlamatLembaga }}</textarea> --}}
                    <h6>{{ $customer->AlamatLembaga }}</h6>
                </div>
                <div class="form-group col-md-6">
                    <label class="text-muted mb-1">Telp.</label>
                    {{-- <input type="text" class="form-control bg-white text-strong" value="{{ $customer->TelpLembaga }}" readonly> --}}
                    <h6>{{ $customer->TelpLembaga }}</h6>
                </div>
                <div class="form-group col-md-6">
                    <label class="text-muted mb-1">E-Mail</label>
                    {{-- <input type="text" class="form-control bg-white text-strong"  value="{{ $customer->EmailLembaga }}" readonly> --}}
                    <h6>{{ $customer->EmailLembaga }}</h6>
                </div>
                <div class="form-group col-md-12">
                    <label class="text-muted mb-1">Catatan</label>
                    {{-- <textarea rows="3" class="form-control bg-white text-strong" readonly>{{ $customer->CatatanLembaga }}</textarea> --}}
                    <h6>{{ $customer->CatatanLembaga }}</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <h4>Data Customer</h4>
        <div class="card">
            <div class="card-body row">
                <div class="col-md-4">
                    <div class="profile-img position-relative">
                        <img src="{{ $customer->photo ? asset('storage/customers/' . $customer->photo) : asset('assets/images/user/1.png') }}" class="img-fluid rounded avatar-110" alt="profile-image">
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <label class="text-muted mb-1">Nama Customer</label>
                    {{-- <input type="text" class="form-control bg-white text-strong" value="{{ $customer->NamaCustomer }}" readonly> --}}
                    <h5>{{ $customer->NamaCustomer }}</h5>
                </div>
                <div class="form-group col-md">
                    <label class="text-muted mb-1">Jabatan</label> <br>
                    <span class="badge
                        {{ strpos($customer->Jabatan, 'Kepala Sekolah') !== false ? 'bg-success' : 
                                (strpos($customer->Jabatan, 'Bendahara') !== false ? 'bg-warning' : 
                                (strpos($customer->Jabatan, 'Operator') !== false ? 'bg-danger' : 'bg-secondary')) }}">
                            {{ $customer->Jabatan }}
                    </span>
                </div>
                <div class="form-group col-md-12">
                    <label class="text-muted mb-1">Alamat</label>
                    {{-- <textarea rows="3" class="form-control bg-white text-strong" readonly>{{ $customer->AlamatCustomer }}</textarea> --}}
                    <h6>{{ $customer->AlamatCustomer }}</h6>
                </div>
                <div class="form-group col-md-6">
                    <label class="text-muted mb-1">Telp.</label>
                    {{-- <input type="text" class="form-control bg-white text-strong" value="{{ $customer->TelpCustomer }}" readonly> --}}
                    <h6>{{ $customer->TelpCustomer }}</h6>
                </div>
                <div class="form-group col-md-6">
                    <label class="text-muted mb-1">E-Mail</label>
                    {{-- <input type="text" class="form-control bg-white text-strong"  value="{{ $customer->EmailCustomer }}" readonly> --}}
                    <h6>{{ $customer->EmailCustomer }}</h6>
                </div>
                <div class="form-group col-md-12">
                    <label class="text-muted mb-1">Catatan</label>
                    {{-- <textarea rows="3" class="form-control bg-white text-strong" readonly>{{ $customer->CatatanCustomer }}</textarea> --}}
                    <h6>{{ $customer->CatatanCustomer }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <ul class="nav nav-tabs mb-1" id="transaction" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="salesorder-tab" data-bs-toggle="tab" href="#salesorder" role="tab"  aria-selected="true"><h6><i class="ti ti-table me-2"></i>Sales Order</h6></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="delivery-tab" data-bs-toggle="tab" href="#delivery" role="tab"  aria-selected="true"><h6><i class="ti ti-table me-2"></i>Delivery Order</h6></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="collection-tab" data-bs-toggle="tab" href="#collection" role="tab"  aria-selected="true"><h6><i class="ti ti-table me-2"></i>Collection</h6></a>
        </li>
    </ul>
    <div class="tab-content" id="transactionContent">
        <!-- Sales Order -->
        @include('marketing.customers.partials.salesorder')
        <!-- Delivery Order -->
        @include('marketing.customers.partials.delivery')
        <!-- Collection -->
        @include('marketing.customers.partials.collection')
    </div>
</div>

@include('components.preview-img-form')
@endsection
