@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('products.index') }}">Produk</a></li>
@endsection

@section('action-button')
    @if (auth()->user()->hasAnyRole('Super Admin', 'Admin', 'Admin Gudang', 'Manajer Marketing'))
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahProduk">Tambah Produk Baru</button>
    <!-- Create -->
    @include('warehouse.products.create')
    @endif
@endsection

@section('container')

<!-- Row & Pencarian -->
<form action="#" method="get">
    <div class="row align-items-center">
        @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Sales', 'Manajer Marketing']))
        <!-- Publisher -->
        <div class="form-group col-md-1">
            <select name="publisher_id" id="publisher_id" class="form-control"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Penerbit" onchange="this.form.submit()">
                <option selected disabled>-- Penerbit --</option>
                <option value="" @if(request('publisher_id') === null) @endif>Semua</option>
                @foreach($publishers as $publisher)
                    <option value="{{ $publisher->id }}" {{ request('publisher_id') == ($publisher->id ?? null) ? 'selected' : '' }}>
                        {{ $publisher->NamaPenerbit ?? '-' }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif
        <!-- Writer -->
        <div class="form-group col-md-1">
            <select name="writer_id" id="writer_id" class="form-control"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Penulis" onchange="this.form.submit()">
                <option selected disabled>-- Penulis --</option>
                <option value="" @if(request('writer_id') === null) @endif>Semua</option>
                @foreach($writers as $writer)
                    <option value="{{ $writer->id }}" {{ request('writer_id') == $writer->id ? 'selected' : '' }}>
                        {{ $writer->NamaPenulis }}
                    </option>
                @endforeach
            </select>
        </div>
        <!-- Jenjang -->
        <div class="form-group col-md-1">
            <select name="jenjang" id="jenjang" class="form-control"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Jenjang" onchange="this.form.submit()">
                <option selected disabled>-- Jenjang --</option>
                <option value="" @if(request('jenjang') == 'null') selected="selected" @endif>Semua</option>
                <option value="SD" @if(request('jenjang') == 'SD') selected="selected" @endif>SD</option>
                <option value="SMP" @if(request('jenjang') == 'SMP') selected="selected" @endif>SMP</option>
                <option value="SMA" @if(request('jenjang') == 'SMA') selected="selected" @endif>SMA</option>
            </select>
        </div>
        <!-- Kelas -->
        <div class="form-group col-md-1">
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
        <!-- Kelas -->
        <div class="form-group col-md-1">
            <select name="category_id" id="category_id" class="form-control"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Kategori" onchange="this.form.submit()">
                <option selected disabled>-- Kategori --</option>
                <option value="" @if(request('category_id') == 'null') selected="selected" @endif>Semua</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }} 
                </option>
            @endforeach
            </select>
        </div>
        <div class="form-group col-md-2">
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
        <div class="form-group col-md">
            <input type="text" id="search" class="form-control" name="search" placeholder="Cari Produk" value="{{ request('search') }}" onblur="this.form.submit()">
        </div>
    </div>
</form>

@if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Admin Gudang', 'Manajer Marketing']))
<ul class="nav nav-tabs mb-3" id="product" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"><h5><i class="ti ti-table me-2"></i>Data</h5></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="datarecap-tab" data-bs-toggle="tab" href="#datarecap" role="tab"><h5><i class="ti ti-table me-2"></i>Rekap</h5></a>
    </li>
</ul>
@endif

<div class="tab-content" id="productContent">
    <!-- All Data -->
    <div class="tab-pane fade show active" id="all" role="tabpanel">
        @include('warehouse.products.partials.table')
    </div>
    <!-- Data Recap -->
    <div class="tab-pane fade" id="datarecap" role="tabpanel">
        @include('warehouse.products.partials.recap')
    </div>
</div>


@endsection

{{-- <script>
    $('#published').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'mm-yyyy',
        startView: "year", 
        minViewMode: "year"
        // https://gijgo.com/datetimepicker/configuration/format
    });
    $('#buying_date').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
        // https://gijgo.com/datetimepicker/configuration/format
    });
    $('#expire_date').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
        // https://gijgo.com/datetimepicker/configuration/format
    });

    // Slug Generator
    const title = document.querySelector("#product_name");
    const slug = document.querySelector("#slug");
    title.addEventListener("keyup", function() {
        let preslug = title.value;
        preslug = preslug.replace(/ /g,"-");
        slug.value = preslug.toLowerCase();
    });
</script> --}}