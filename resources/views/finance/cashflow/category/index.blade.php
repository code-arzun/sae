@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('cashflow.index') }}">Arus Kas</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('cashflowcategory.index') }}">Kategori</a></li>
@endsection

@section('action-button')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKategoriTransaksi"><i class="ti ti-plus"></i> Tambah Kategori Baru</button>
    <!-- Create -->
    @include('finance.cashflow.category.create')
@endsection

@section('container')

<div class="row">
    {{-- <div class="card col-md-4">
        <div class="card-body">
            <h3>Tambah {{ $title }} Baru</h3>
            <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Jenis Transaksi -->
                    <div class="form-group col-md-6">
                        <label for="type">Jenis Transaksi</label>
                        <select class="form-control @error('type') is-invalid @enderror" name="type">
                            <option value="" selected disabled>-- Jenis Transaksi --</option>
                            <option value="Pemasukan">Pemasukan</option>
                            <option value="Pengeluaran">Pengeluaran</option>
                        </select>
                        @error('type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <!-- Kategori -->
                    <div class="form-group col-md-6">
                        <label for="category">Kategori</label>
                        <select class="form-control @error('category') is-invalid @enderror" name="category">
                            <option value="" selected disabled>-- Kategori --</option>
                            <option value="Modal">Modal</option>
                            <option value="Penjualan">Penjualan</option>
                            <option value="Pembayaran">Pembayaran</option>
                            <option value="Pembelian">Pembelian</option>
                        </select>
                        @error('category')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <!-- Detail Transaksi -->
                    <div class="form-group">
                        <label for="detail">Detail</label>
                        <input type="text" class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail" value="{{ old('detail') }}" placeholder="contoh: Bahan Baku, Mesin, BBM, dll.">
                        @error('detail')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    </form>
                </div>
        </div>
    </div> --}}

    <div class="dt-responsive table-responsive col-md-6">
        <div class="d-flex justify-content-between mb-3">
            <h4 class="text-success">Pemasukan</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createIncomeCategory"><i class="ti ti-plus"></i> Tambah Kategori Pemasukan</button>
            <!-- Create -->
            @include('finance.cashflow.category.create-income')
        </div>
        <table class="table table-hover bg-white mb-0">
            @include('finance.cashflow.category.partials.head')
            <tbody>
                @forelse ($cashflowcategories as $cashflowcategory)
                    @if ($cashflowcategory->type === 'Pemasukan')
                        @include('finance.cashflow.category.partials.data')
                    @endif
        
                @empty
                    @include('layout.partials.alert-danger')
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="dt-responsive table-responsive col-md-6">
        <div class="d-flex justify-content-between mb-3">
            <h4 class="text-danger">Pengeluaran</h4>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createExpenditureCategory"><i class="ti ti-plus"></i> Tambah Kategori Pengeluaran</button>
            <!-- Create -->
            @include('finance.cashflow.category.create-expenditure')
        </div>
        <table class="table table-hover bg-white mb-0">
            @include('finance.cashflow.category.partials.head')
            <tbody>
                @forelse ($cashflowcategories as $cashflowcategory)
                    @if ($cashflowcategory->type === 'Pengeluaran')
                        @include('finance.cashflow.category.partials.data')
                    @endif
        
                @empty
                    @include('layout.partials.alert-danger')
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
