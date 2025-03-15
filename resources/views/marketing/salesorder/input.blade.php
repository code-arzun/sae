@extends('layout.main')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

@section('container')

<div class="row">
    <div class="d-flex justify-content-between mb-3">
        <div>
            <h2>Input Sales Order</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-default-icon">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti ti-home-2"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('so.index') }}">Sales Order</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('input.so') }}">Input</a></li>
                </ol>
            </nav>
        </div>
        <div>
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
        </div>
    </div>
    
    <!-- Produk -->
    <div class="col-lg-5 col-md-12">
        <!-- Pencarian & Filter -->
        <form action="#" method="get">
            <div class="d-flex flex-wrap align-items-center row">
                <div class="form-group col-sm-3">
                    <select name="jenjang" id="jenjang" class="form-control"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Jenjang" onchange="this.form.submit()">
                        <option selected disabled>-- Jenjang --</option>
                        <option value="" @if(request('jenjang') == 'null') selected="selected" @endif>Semua</option>
                        <option value="SD" @if(request('jenjang') == 'SD') selected="selected" @endif>SD</option>
                        <option value="SMP" @if(request('jenjang') == 'SMP') selected="selected" @endif>SMP</option>
                        <option value="SMA" @if(request('jenjang') == 'SMA') selected="selected" @endif>SMA</option>
                    </select>
                </div>
                <div class="form-group col-sm-3">
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
                <div class="form-group col-sm-3">
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
                <div class="form-group col-sm-3">
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
        <table class="table table-striped bg-white nowrap mt-2">
            <thead>
                <tr>
                    {{-- <th colspan="2">@sortablelink('product_name', 'Nama Produk')</th> --}}
                    <th>@sortablelink('product_name', 'Nama Produk')</th>
                    {{-- <th>@sortablelink('category', 'Kategori')</th> --}}
                    <th>@sortablelink('selling_price', 'Harga')</th>
                    <th>@sortablelink('stock', 'Stok')</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    {{-- <td>{{ (($products->currentPage() * 10) - 10) + $loop->iteration  }}</td> --}}
                    <td class="text-left" 
                        {{-- data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="{{ $product->category->name }} || Rp {{ number_format($product->selling_price) }}" --}}
                        >
                        <h6>{{ $product->product_name }}</h6>
                        <p>{{ $product->category->name }}</p>
                    </td>
                    {{-- <td class="text-left">{{ $product->category->name }}</td> --}}
                    <td class="text-end">Rp {{ number_format($product->selling_price) }}</td>
                    <td class="text-center">
                        @if ($product->product_store > 100)
                            <span class="badge bg-success">{{number_format($product->product_store) }}</span>
                        @elseif ($product->product_store >= 50 && $product->product_store <= 99)
                            <span class="badge bg-warning">{{number_format($product->product_store) }}</span>
                        @else
                            <span class="badge bg-danger">{{number_format($product->product_store) }}</span>
                        @endif
                        <span class="ml-3">{{ $product->category->productunit->name }}</span>
                    </td>
                    <td>
                        <form action="{{ route('inputso.addCart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->product_name }}">
                            <input type="hidden" name="category" value="{{ $product->category->name }}">
                            <input type="hidden" name="price" value="{{ $product->selling_price }}">
                            <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Tambah"><i class="ti ti-plus"></i></button>
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
        {{ $products->links() }}
    </div>
    
    <!-- Cart -->
    <div class="col-lg-7 col-md-12">
        <table class="table">
            <thead>
                <tr class="light text-center">
                    <th width="50px">#</th>
                    <th>Nama Produk</th>
                    <th width="160px">Kategori</th>
                    <th width="50px">Jumlah</th>
                    <th width="120px">Harga</th>
                    <th width="150px">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productItem as $item)
                <tr>
                    <td class="text-center">
                        <a href="{{ route('inputso.deleteCart', $item->rowId) }}" class="btn bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Hapus"><i class="fa-solid fa-trash me-0"></i></a>
                    </td>
                    <td><b>{{ $item->name }}</b></td>
                    <td><i>{{ $item->category }}</i></td>
                    <td>
                        <form action="{{ route('inputso.updateCart', $item->rowId) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="number" class="form-control text-center" style="width:100px" name="qty" required
                                    value="{{ old('qty', $item->qty) }}" onblur="this.form.submit()">
                            </div>
                        </form>
                    </td>
                    <td class="text-end pricing">Rp {{ number_format($item->price) }}</td>
                    <td class="text-end">Rp {{ number_format($item->subtotal) }}</td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Total -->
        <table class="table table-striped table-bordered nowrap">
            <thead class="light">
                <tr class="text-end">
                    <th>Total Item<span class="badge bg-secondary ml-3">{{ number_format(count(Cart::content())) }}</span></th>
                    <th>Total Barang<span class="badge bg-primary ml-3">{{ number_format(Cart::count()) }}</span></th>
                    <th>Subtotal<span class="badge bg-success ml-3">Rp {{ number_format(Cart::subtotal()) }}</span>  
                        <span id="subtotal" hidden>{{ Cart::subtotal() }}</span>
                    </th>
                </tr>
            </thead>
            <!-- Diskon -->
            <tbody>
                <form action="{{ route('inputso.confirmation') }}" method="POST">
                    @csrf
                    <tr>
                        <th class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Gunakan titik (.) sebagai pemisah!">Diskon (%)</th>
                        <th>
                            <div class="input-group">
                                <input type="number" step="0.01" data-bs-toggle="tooltip" data-bs-placement="top" title="Gunakan titik (.) sebagai pemisah!"
                                    onclick="calculateDiscount()" onkeyup="calculateDiscount()" class="form-control text-center"
                                    id="discount_percent" name="discount_percent" value="{{ old('discount_percent', 0) }}">
                            </div>
                        </th>
                        <th>
                            <input type="number" class="form-control text-center bg-white" id="discount_rp" name="discount_rp" value="{{ old('discount_rp', 0) }}" readonly>
                        </th>
                    </tr>
            </tbody>
            <!-- Grand Total -->
            <tfoot class="light">
                <tr>
                    <th colspan="2" class="text-end">Grand Total</th>
                    <th>
                        <input type="number" class="form-control bg-white text-center" id="grandtotal" name="grandtotal" value="{{ old('grandtotal', 0) }}" readonly>
                    </th>
                    
                </tr>
            </tfoot>
        </table>

        <div class="row">
            {{-- <div class="form-group col-md-6">
                <label for="order_date">Tanggal Pemesanan</label>
                <input id="order_date" class="form-control @error('order_date') is-invalid @enderror" name="order_date" value="{{ old('order_date') }}" />
                @error('order_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div> --}}
            <div class="col-md-12 mt-3">
                <div class="form-group">
                    <label for="customer_id">Pilih Customer</label>
                    <select class="form-control select2" id="customer_id" name="customer_id" required>
                        <option selected="" disabled="">-- Customer --</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" 
                                    data-nama-lembaga="{{ $customer->NamaLembaga }}"
                                    data-nama-customer="{{ $customer->NamaCustomer }}"
                                    data-jabatan="{{ $customer->Jabatan }}"
                                    @if (auth()->user()->hasAnyRole('Super Admin', 'Manajer Marketing', 'Admin'))
                                    data-employee-name="{{ $customer->employee->name }}"
                                    @endif>
                                {{ $customer->NamaLembaga }} | {{ $customer->NamaCustomer }} - {{ $customer->Jabatan }}
                                @if (auth()->user()->hasAnyRole('Super Admin', 'Manajer Marketing', 'Admin'))
                                | {{ $customer->employee->name }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('customer_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-success w-100"><b>Buat Pesanan</b></button>
            </div>
        </div>
    </form>
    </div>
</div>

    
@include('components.preview-img-form')

@endsection

<script>
$(document).ready(function () {
    if ($.fn.select2 === undefined) {
        console.error("Select2 tidak dimuat! Periksa apakah script Select2 sudah di-load.");
        return;
    }

    $('#customer_id').select2({
        templateResult: formatOption,
        templateSelection: formatOptionSelection
    });

    function formatOption(option) {
        if (!option.id) {
            return option.text;
        }

        let namaLembaga = $(option.element).data('nama-lembaga') || '';
        let namaCustomer = $(option.element).data('nama-customer') || '';
        let jabatan = $(option.element).data('jabatan') || '';
        let employeeName = $(option.element).data('employee-name') || '';

        let content = $(`
            <div class="select2-table-row">
                <div class="select2-table-cell">${namaLembaga}</div>
                <div class="select2-table-cell">${namaCustomer}</div>
                <div class="select2-table-cell">${jabatan}</div>
                ${employeeName ? `<div class="select2-table-cell">${employeeName}</div>` : ''}
            </div>
        `);

        return content;
    }

    function formatOptionSelection(option) {
        return option.text;
    }
});
</script>