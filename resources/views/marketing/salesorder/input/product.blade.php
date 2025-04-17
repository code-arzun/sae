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
<table class="table nowrap mt-2">
    <thead>
        <tr>
            <th>Nama Produk</th>
            <th width="150px">Harga</th>
            <th width="50px">Stok</th>
            <th width="50px">#</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
        <tr>
            <td>
                <h5>{{ $product->product_name }}</h5>
                <span class="text-secondary">{{ $product->category->name }}</span>
            </td>
            <td class="text-end">Rp {{ number_format($product->selling_price) }}</td>
            <td class="text-center">
                @if ($product->product_store > 100)
                    <b class="text-success">{{number_format($product->product_store) }}</b>
                @elseif ($product->product_store >= 50 && $product->product_store <= 99)
                    <b class="text-warning">{{number_format($product->product_store) }}</b>
                @else
                    <b class="text-danger">{{number_format($product->product_store) }}</b>
                @endif
                {{-- <span class="ml-3">{{ $product->category->productunit->name }}</span> --}}
            </td>
            <form action="{{ route('inputso.addCart') }}" method="POST">
            <td>
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <input type="hidden" name="name" value="{{ $product->product_name }}">
                    <input type="hidden" name="category" value="{{ $product->category->name }}">
                    <input type="hidden" name="price" value="{{ $product->selling_price }}">
                    <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Tambah">
                        <i class="ti ti-plus"></i>
                    </button>
                </td>
            </form>
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