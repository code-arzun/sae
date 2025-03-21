@extends('layout.main')

@section('container')

<div class="d-flex justify-content-between mb-3">
    <div>
        <h2>{{ $title }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-default-icon">
                @include('marketing.salesorder.partials.breadcrumb')
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('input.so') }}">Input</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('inputso.confirmation') }}">Konfirmasi</a></li>
            </ol>
        </nav>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">Tanggal</span>
                <h4 class="mb-0"></h4>
            </div>
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">Nama Lembaga</span>
                <h4 class="mb-0">{{ $customer->NamaLembaga }}</h4>
            </div>
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">Nama Customer</span>
                <h4 class="mb-0">{{ $customer->NamaCustomer }}</h4>
            </div>
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">Jabatan</span>
                <h4 class="mb-0">{{ $customer->Jabatan }}</h4>
            </div>
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">Sales</span>
                <h4 class="mb-0">{{ $customer->employee->name }}</h4>
            </div>
        </div>
       
        <!-- Detail Pesanan -->
        <table class="table table-striped nowrap">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th width="250px">Kategori</th>
                    <th width="150px">Harga</th>
                    <th width="150px">Jumlah</th>
                    <th width="150px">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($content as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category }}</td>
                    <th class="text-end">Rp {{ number_format($item->price) }}</th>
                    <th class="text-end">{{ number_format($item->qty) }}</th>
                    <th class="text-end">Rp {{ number_format($item->subtotal) }}</th>
                </tr>
                @endforeach
            </tbody>
        </table>
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
    </div>
</div>
<div class="col">
    <a href="#" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#save">
        Simpan
    </a>
    @include('marketing.salesorder.input.save')
</div>

@endsection
