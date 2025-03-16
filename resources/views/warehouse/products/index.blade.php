@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @if (session()->has('success'))
                <div class="alert text-white bg-success" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            <div class="col d-flex flex-wrap align-items-top justify-content-between mb-3">
                <div class="row">
                    <a href="{{ url()->previous() }}" class="badge bg-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left mb-1 mt-1"></i></a>
                    <a href="{{ route('products.index') }}" class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div class="row d-flex flex-wrap align-items-center justify-content-between">
                    <div class="mr-3">
                        <h5>Data Produk</h5>
                    </div>
                    <div class="">
                        <a href="{{ route('products.create') }}" class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Produk"><i class="fa fa-plus mb-1 mt-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row & Pencarian -->
        <div class="col-lg-12 mb-3">
            <form action="{{ route('products.index') }}" method="get">
                <div class="row align-items-center">
                    @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Sales', 'Manajer Marketing']))
                    <div class="form-group col-sm-1">
                        <select name="publisher_id" id="publisher_id" class="form-control"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Penerbit" onchange="this.form.submit()">
                            <option selected disabled>-- Penerbit --</option>
                            <option value="" @if(request('publisher_id') === null) selected @endif>Semua</option>
                            @foreach($publishers as $publisher)
                                <option value="{{ $publisher->publisher_id }}" {{ request('publisher_id') == ($publisher->publisher_id ?? null) ? 'selected' : '' }}>
                                    {{ $publisher->publisher->NamaPenerbit ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="form-group col-sm-2">
                        <select name="writer_id" id="writer_id" class="form-control"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Penulis" onchange="this.form.submit()">
                            <option value="" @if(request('writer_id') === null) selected @endif>Semua</option>
                            @foreach($writers as $writer)
                                @if(empty($writer->writer->NamaPenulis))
                                    <option selected disabled value="">-- Penulis --</option>
                                @else
                                    <option value="{{ $writer->writer_id }}" {{ request('writer_id') == $writer->writer_id ? 'selected' : '' }}>
                                        {{ $writer->writer->NamaPenulis }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-1">
                        <select name="jenjang" id="jenjang" class="form-control"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Jenjang" onchange="this.form.submit()">
                            <option selected disabled>-- Jenjang --</option>
                            <option value="" @if(request('jenjang') == 'null') selected="selected" @endif>Semua</option>
                            <option value="SD" @if(request('jenjang') == 'SD') selected="selected" @endif>SD</option>
                            <option value="SMP" @if(request('jenjang') == 'SMP') selected="selected" @endif>SMP</option>
                            <option value="SMA" @if(request('jenjang') == 'SMA') selected="selected" @endif>SMA</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-1">
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
                    <div class="form-group col-sm-2">
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
                    <div class="form-group col-sm-2">
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
                    <div class="form-group col-sm">
                        <input type="text" id="search" class="form-control" name="search" placeholder="Cari Produk" value="{{ request('search') }}" onblur="this.form.submit()">
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            {{-- <th>@sortablelink('product_code', 'Kode Produk')</th> --}}
                            <th colspan="2">@sortablelink('product_name', 'Nama Produk')</th>
                            <th>@sortablelink('category.name', 'Kategori')</th>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Sales', 'Manajer Marketing']))
                            <th>@sortablelink('publisher.NamaPenerbit', 'Penerbit')</th>
                            @endif
                            @if (auth()->user()->hasAnyRole(['Staf Publishing', 'Admin Publishing', 'Manajer Publishing']))
                            <th>@sortablelink('writer.NamaPenulis', 'Penulis')</th>
                            @endif
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Sales', 'Manajer Marketing']))
                            {{-- <th>@sortablelink('buying_price', 'Harga Beli')</th> --}}
                            <th>@sortablelink('selling_price', 'Harga Jual')</th>
                            <th>Status</th>
                            @endif
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td>{{ (($products->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td><img class="avatar-60 rounded" src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.webp') }}"></td>
                            <td> <b>{{ $product->product_name }}</b> </td>
                            {{-- <td>
                                <div class="row">
                                    <div class="col-md-4 me-1">
                                        <img class="avatar-60 rounded" src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.webp') }}">
                                    </div>
                                    <div class="col-md">
                                        <b>{{ $product->product_name }}</b> <br>
                                        {{ $product->product_code }}
                                    </div>
                                </div>
                            </td> --}}
                            <td>{{ $product->category->name }}</td>
                            @if (auth()->user()->hasAnyRole(['Staf Publishing', 'Admin Publishing', 'Manajer Publishing']))
                            <td>
                                @if ($product->writer)
                                    <b>{{ $product->writer->NamaPenulis }}</b>
                                @else
                                    -
                                @endif
                            </td>
                            @endif
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Sales', 'Manajer Marketing']))
                            <td>
                                @if ($product->publisher_id)
                                    <b>{{ $product->publisher->NamaPenerbit }}</b>
                                @else
                                    -
                                @endif
                            </td>
                            {{-- <td>Rp {{ number_format($product->buying_price) }}</td> --}}
                            <td>Rp {{ number_format($product->selling_price) }}</td>
                            <td>
                                @if ($product->expire_date > Carbon\Carbon::now()->format('Y-m-d'))
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            @endif
                            <td>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="margin-bottom: 5px">
                                    @method('delete')
                                    @csrf
                                    <div class="d-flex align-items-center list-action">
                                        <a class="btn btn-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Lihat Detail"
                                            href="{{ route('products.show', $product->id) }}"><i class="ri-eye-line me-0"></i>
                                        </a>
                                        <a class="btn btn-warning me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Edit"
                                            href="{{ route('products.edit', $product->id) }}"><i class="ri-pencil-line me-0"></i>
                                        </a>
                                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                                            <button type="submit" class="btn btn-danger me-2 border-none" onclick="return confirm('Are you sure you want to delete this record?')" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Hapus"><i class="ri-delete-bin-line me-0"></i></button>
                                        @endif
                                    </div>
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
    <!-- Page end  -->
</div>

@endsection
