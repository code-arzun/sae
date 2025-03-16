@extends('layout.main')

@section('container')
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12 d-flex flex-wrap align-items-top justify-content-between mb-3">
            @if (session()->has('success'))
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        showSuccessAlert("{{ session('success') }}");
                    });
                </script>
            @elseif (session()->has('created'))
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        showCreatedAlert("{{ session('created') }}");
                    });
                </script>
            @endif
            <div>
                <a href="{{ url()->previous() }}" class="badge bg-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left mb-1 mt-1"></i></a>
                <a href="{{ route('input.stock') }}" class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
            </div>
            <div>
                <h4>Input Stok Masuk</h4>
            </div>
        </div>

       <!-- Produk -->
        <div class="col-lg-5 col-md-12">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <form action="#" method="get">
                        <div class="d-flex flex-wrap align-items-center row">
                            <div class="form-group col-sm-3 mb-3">
                                <select name="jenjang" id="jenjang" class="form-control"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Jenjang" onchange="this.form.submit()">
                                    <option selected disabled>-- Jenjang --</option>
                                    <option value="" @if(request('jenjang') == 'null') selected="selected" @endif>Semua</option>
                                    <option value="SD" @if(request('jenjang') == 'SD') selected="selected" @endif>SD</option>
                                    <option value="SMP" @if(request('jenjang') == 'SMP') selected="selected" @endif>SMP</option>
                                    <option value="SMA" @if(request('jenjang') == 'SMA') selected="selected" @endif>SMA</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-3 mb-3">
                                <select name="kelas" id="kelas" class="form-control"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Kelas" onchange="this.form.submit()">
                                    <option selected disabled>-- Kelas --</option>
                                    <option value="" @if(request('kelas') == 'null') selected="selected" @endif>Semua</option>
                                    <option value="Kelas 1" @if(request('kelas') == 'Kelas 1') selected="selected" @endif>Kelas 1</option>
                                    <option value="Kelas 2" @if(request('kelas') == 'Kelas 2') selected="selected" @endif>Kelas 2</option>
                                    <option value="Kelas 3" @if(request('kelas') == 'Kelas 3') selected="selected" @endif>Kelas 3</option>
                                    <option value="Kelas 4" @if(request('kelas') == 'Kelas 4') selected="selected" @endif>Kelas 4</option>
                                    <option value="Kelas 5" @if(request('kelas') == 'Kelas 5') selected="selected" @endif>Kelas 5</option>
                                    <option value="Kelas 6" @if(request('kelas') == 'Kelas 6') selected="selected" @endif>Kelas 6</option>
                                    <option value="Kelas 7" @if(request('kelas') == 'Kelas 7') selected="selected" @endif>Kelas 7</option>
                                    <option value="Kelas 8" @if(request('kelas') == 'Kelas 8') selected="selected" @endif>Kelas 8</option>
                                    <option value="Kelas 9" @if(request('kelas') == 'Kelas 9') selected="selected" @endif>Kelas 9</option>
                                    <option value="Kelas 10" @if(request('kelas') == 'Kelas 10') selected="selected" @endif>Kelas 10</option>
                                    <option value="Kelas 11" @if(request('kelas') == 'Kelas 11') selected="selected" @endif>Kelas 11</option>
                                    <option value="Kelas 12" @if(request('kelas') == 'Kelas 12') selected="selected" @endif>Kelas 12</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-3 mb-3">
                                <select name="category_id" id="category_id" class="form-control"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Kategori" onchange="this.form.submit()">
                                    <option selected disabled>-- Kategori --</option>
                                    <option value="" @if(request('category_id') == 'null') selected="selected" @endif>Semua</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category->id ? 'selected' : '' }}>
                                        {{ $category->category->name }} 
                                    </option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-3 mb-3">
                                <select name="mapel" id="mapel" class="form-control"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Mata Pelajaran" onchange="this.form.submit()">
                                    <option selected disabled>-- Mata Pelajaran --</option>
                                    <option value="" @if(request('mapel') == 'null') selected="selected" @endif>Semua</option>
                                    <option value="Indonesia" @if(request('mapel') == 'Indonesia') selected="selected" @endif>Bahasa Indonesia</option>
                                    <option value="Jawa" @if(request('mapel') == 'Jawa') selected="selected" @endif>Bahasa Jawa</option>
                                    <option value="Inggris" @if(request('mapel') == 'Inggris') selected="selected" @endif>Bahasa Inggris</option>
                                    <option value="Matematika" @if(request('mapel') == 'Matematika') selected="selected" @endif>Matematika</option>
                                    <option value="IPAS" @if(request('mapel') == 'IPAS') selected="selected" @endif>IPAS</option>
                                    <option value="Pancasila" @if(request('mapel') == 'Pancasila') selected="selected" @endif>Pend. Pancasila</option>
                                    <option value="Islam" @if(request('mapel') == 'Islam') selected="selected" @endif>Pend. Agama Islam</option>
                                    <option value="PJOK" @if(request('mapel') == 'PJOK') selected="selected" @endif>PJOK</option>
                                    <option value="Rupa" @if(request('mapel') == 'Rupa') selected="selected" @endif>Seni Rupa</option>
                                    <option value="Musik" @if(request('mapel') == 'Musik') selected="selected" @endif>Seni Musik</option>
                                    <option value="Tari" @if(request('mapel') == 'Tari') selected="selected" @endif>Seni Tari</option>
                                    <option value="Teater" @if(request('mapel') == 'Teater') selected="selected" @endif>Seni Teater</option>
                                    <option value="PPKN" @if(request('mapel') == 'PPKN') selected="selected" @endif>PPKN</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-12">
                                <input type="text" id="search" class="form-control" name="search" placeholder="Cari Produk" value="{{ request('search') }}" onblur="this.form.submit()">
                            </div>
                        </div>
                    </form>

                    <!-- Daftar Produk -->
                    <div class="dt-responsive table-responsive mb-3 border-none">
                        <table class="table mt-2">
                            <thead>
                                <tr>
                                    <th>@sortablelink('product_name', 'Nama Produk')</th>
                                    <th>Tambah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                <tr>
                                    {{-- <td>{{ (($products->currentPage() * 10) - 10) + $loop->iteration  }}</td> --}}
                                    <td class="text-left" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="{{ $product->category->name }} || Rp {{ number_format($product->selling_price) }}">
                                        <b >{{ $product->product_name }}</b>
                                    </td>
                                    <td>
                                        <form action="{{ route('inputso.addCart') }}" method="POST"  style="margin-bottom: 5px">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <input type="hidden" name="name" value="{{ $product->product_name }}">
                                            <input type="hidden" name="category" value="{{ $product->category->name }}">
                                            <input type="hidden" name="price" value="{{ $product->selling_price }}">
                                            <button type="submit" class="btn btn-primary border-none" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Tambah"><i class="far fa-plus me-0"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <div class="alert text-white bg-danger" role="alert">
                                    <div class="iq-alert-text">Data tidak ditemukan!</div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="ri-close-line"></i>
                                    </button>
                                </div>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>

        {{-- Cart --}}
        <div class="col-lg-7 col-md-12 mb-5">
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align: center">Nama Produk</th>
                        {{-- <th style="text-align: center">Kategori</th> --}}
                        <th style="text-align: center">Jumlah</th>
                        <th style="text-align: center">Harga</th>
                        <th style="text-align: center">Total</th>
                        <th style="text-align: center">Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productItem as $item)
                    <tr>
                        <td>{{ $item->name }}
                            <p>{{ $item->category }}
                            </p>
                        </td>
                        {{-- <td>{{ $item->category }}</td> --}}
                        <td style="min-width: 140px;">
                            <form action="{{ route('inputstock.updateCart', $item->rowId) }}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="number" style="width: 50px;" class="form-control" name="qty" required value="{{ old('qty', $item->qty) }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-sm btn-success border-none" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Perbarui"><i class="fas fa-check"></i></button>
                                    </div>
                                </div>
                            </form>
                        </td>
                        <td style="text-align: right">Rp {{ number_format($item->price) }}</td>
                        <td style="text-align: right">Rp {{ number_format($item->subtotal) }}</td>
                        <td>
                            <a href="{{ route('inputstock.deleteCart', $item->rowId) }}" class="btn btn-warning border-none" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Delete"><i class="fa-solid fa-trash me-0"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
                
                <br>
                <table class="table">
                    <tr>
                        <td width="25%"style="text-align: right">Total Barang</td>
                        <td width="25%"style="text-align: center"><b>{{ number_format(Cart::count()) }}</b></td>
                        <td width="25%"style="text-align: right">Subtotal</td>
                        <td width="25%"style="text-align: right"><b>Rp {{ number_format(Cart::subtotal()) }}</b></td>
                        <td></td>
                    </tr>
                </table>

            <br>

            <form action="{{ route('inputstock.confirmation') }}" method="POST">
                @csrf
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="input-group">
                            <select class="form-control" id="supplier_id" name="supplier_id">
                                <option selected="" disabled="">-- Pilih Supplier --</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('supplier_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    

                    <div class="col-md-12 mt-4">
                        <div class="d-flex flex-wrap align-items-center justify-content-center">
                            <button type="submit" class="btn btn-success add-list mx-1">Buat Stok Masuk</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        
    </div>
</div>
@endsection
