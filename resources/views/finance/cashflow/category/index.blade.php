@extends('layout.main')

@section('container')

<div class="d-flex justify-content-between mb-3">
    <div>
        <h2>{{ $title }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-default-icon">
                @include('finance.cashflow.category.partials.breadcrumb')
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('cashflowcategory.index') }}">Kategori</a></li>
            </ol>
        </nav>
    </div>
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKategoriTransaksi">Tambah Kategori Baru</button>
        <!-- Create -->
        @include('finance.cashflow.category.create')
    </div>
</div>



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
        <h4 class="text-success">Pemasukan</h4>
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
        <h4 class="text-danger">Pengeluaran</h4>
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
