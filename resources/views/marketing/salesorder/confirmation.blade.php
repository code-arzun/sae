@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('so.index') }}">Sales Order</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('input.so') }}">Input</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('inputso.confirmation') }}">Konfirmasi</a></li>
@endsection

@section('container')

<div class="card">
    <div class="card-body row">
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Tanggal</span>
            <h4 class="mb-0"></h4>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Nama Lembaga</span>
            <h4 class="mb-0">{{ $customer->NamaLembaga }}</h4>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Nama Customer</span>
            <h4 class="mb-0">{{ $customer->NamaCustomer }}</h4>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Jabatan</span>
            <h4 class="mb-0">{{ $customer->Jabatan }}</h4>
        </div>
        <div class="col-md d-flex flex-column">
            <span class="text-secondary mb-1">Sales</span>
            <h4 class="mb-0">{{ $customer->employee->name }}</h4>
        </div>
    </div>
</div>

<!-- Detail Pesanan -->
@include('layout.table.confirmation-detail')

<div class="offset-lg-8">
    <table class="table text-end">
        <tr>
            <th>Total Item</th>
            <th><span class="badge bg-secondary w-100"> {{ number_format(count(Cart::content())) }}</span></th>
            <th>Total Barang</th>
            <th><span class="badge bg-secondary w-100"> {{ number_format(Cart::count()) }}</span></th>
            <th>Subtotal</th>
            <th><span class="badge bg-success w-100">Rp {{ number_format(Cart::subtotal()) }}</span></th>
        </tr>
        <tr>
            <td colspan="4">Diskon</td>
            <th>{{ number_format($discount_percent) }} %</th>
            <th><span class="badge bg-danger w-100">Rp {{ number_format($discount_rp) }}</span></th>
        </tr>
        <tr>
            <td colspan="5">Grand Total</td>
            <th><span class="badge bg-primary w-100">Rp {{ number_format($grandtotal) }}</span></th>
        </tr>
    </table>
</div>
<div class="col">
    <a href="#" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#saveSOModal">
        Simpan
    </a>
    @include('marketing.salesorder.input.save')
</div>

@endsection
