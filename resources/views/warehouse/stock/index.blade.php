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
                    <a href="{{ url()->previous() }}" class="badge bg-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left"></i></a>
                    <a href="{{ route('product.stock') }}" class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh"></i></a>
                </div>
                <div class="row d-flex flex-wrap align-items-center justify-content-between">
                    <div class="mr-3">
                        <h4>Stok Produk</h4>
                    </div>
                    @if (auth()->user()->hasAnyRole('Super Admin', 'Admin', 'Admin Gudang'))
                    {{-- <div class="">
                        <a href="{{ route('products.exportData') }}" class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Excel"><i class="fa fa-file-excel"></i></a>
                    </div> --}}
                    @endif
                </div>
            </div>
        </div>

        <!-- Row & Pencarian -->
        <div class="col-lg-12 mb-3">
            <form action="{{ route('product.stock') }}" method="get">
                <div class="row align-items-center">
                    <div class="form-group col-sm-1">
                        <a href="{{ route('products.exportData') }}" class="btn bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Excel"><i class="fa fa-file-excel"></i></a>
                    </div>
                </div>
                <div class="row align-items-center">
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
                    <thead class="bg-white text-uppercase text-center">
                        <tr>
                            <th>No.</th>
                            <th>@sortablelink('product_name', 'Nama Produk')</th>
                            <th>@sortablelink('category.name', 'Kategori')</th>
                            <th>@sortablelink('selling_price', 'Harga')</th>
                            <th>@sortablelink('product_store', 'Stok Tersedia')</th>
                            @if (auth()->user()->hasAnyRole('Super Admin', 'Admin', 'Admin Gudang'))
                            <th data-bs-toggle="tooltip" data-bs-placement="top" title="Rekap dari Total Produk yang TERKIRIM">@sortablelink('SO Diajukan')</th>
                            <th data-bs-toggle="tooltip" data-bs-placement="top" title="Rekap dari Total Produk yang TERKIRIM">@sortablelink('SO Disetujui')</th>
                            <th>Stok Dibutuhkan</th>
                            <th data-bs-toggle="tooltip" data-bs-placement="top" title="Rekap dari Total Produk yang TERKIRIM">@sortablelink('DO Terpacking')</th>
                            <th data-bs-toggle="tooltip" data-bs-placement="top" title="Rekap dari Total Produk yang TERKIRIM">@sortablelink('DO Dalam Pengiriman')</th>
                            <th data-bs-toggle="tooltip" data-bs-placement="top" title="Rekap dari Total Produk yang TERKIRIM">@sortablelink('DO Terkirim')</th>
                            <th data-bs-toggle="tooltip" data-bs-placement="top" title="Rekap dari Total Produk yang DIPESAN, TERKIRIM, dan TELAH DIBAYAR LUNAS">@sortablelink('Rekap Selesai')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td>{{ (($products->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>
                                <img class="avatar-60 rounded me-3" src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.webp') }}">
                                <b>{{ $product->product_name }}</b>
                            </td>
                            <td>{{ $product->category->name }}</td>
                            <td>Rp {{ number_format($product->selling_price) }}</td>
                            <td class="text-center">
                                @if ($product->product_store >= 100)
                                    <span class="badge bg-success">{{ $product->product_store }}</span>
                                @elseif ($product->product_store >= 50 && $product->product_store <= 99)
                                    <span class="badge bg-warning">{{ $product->product_store }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $product->product_store }}</span>
                                @endif
                                <span class="ml-1">{{ $product->category->productunit->name }}</span>
                            </td>
                            @if (auth()->user()->hasAnyRole('Super Admin', 'Admin', 'Admin Gudang'))
                            <!-- SO Diajukan -->
                            <td class="text-center">
                                @if ($product->rekap_SOdiajukan > 0)
                                    <span class="badge bg-danger">{{ $product->rekap_SOdiajukan }}</span>{{ $product->category->productunit->name }}
                                @else
                                    <span class="badge bg-success">{{ $product->rekap_SOdiajukan }}</span>{{ $product->category->productunit->name }}
                                @endif
                            </td>
                            <!-- SO disetujui -->
                            <td class="text-center">
                                @if ($product->rekap_SOdisetujui - $product->rekap_DOterpacking - $product->rekap_DOpengiriman - $product->rekap_DOterkirim > 0)
                                    <span class="badge bg-danger">{{ $product->rekap_SOdisetujui - $product->rekap_DOterpacking - $product->rekap_DOpengiriman - $product->rekap_DOterkirim }}</span>{{ $product->category->productunit->name }}
                                @else
                                    <span class="badge bg-success">{{ $product->rekap_SOdisetujui - $product->rekap_DOterpacking - $product->rekap_DOpengiriman - $product->rekap_DOterkirim }}</span>{{ $product->category->productunit->name }}
                                @endif
                            </td>
                            <!-- Stok dibutuhkan -->
                            <td class="text-center">
                                @if ($product->rekap_SOdisetujui-$product->product_store > 0)
                                    <span class="badge bg-danger">{{ $product->rekap_SOdisetujui-$product->product_store }}</span>{{ $product->category->productunit->name }}
                                @else
                                    <span class="badge bg-success">{{ $product->rekap_SOdisetujui-$product->product_store }}</span>{{ $product->category->productunit->name }}
                                @endif
                            </td>
                            <!-- DO terpacking -->
                            <td class="text-center">
                                @if ($product->rekap_DOterpacking > 0)
                                    <span class="badge bg-danger">{{ $product->rekap_DOterpacking }}</span>{{ $product->category->productunit->name }}
                                @else
                                    <span class="badge bg-success">{{ $product->rekap_DOterpacking }}</span>{{ $product->category->productunit->name }}
                                @endif
                            </td>
                            <!-- DO dalam pengiriman -->
                            <td class="text-center">
                                @if ($product->rekap_DOpengiriman > 0)
                                    <span class="badge bg-danger">{{ $product->rekap_DOpengiriman }}</span>{{ $product->category->productunit->name }}
                                @else
                                    <span class="badge bg-success">{{ $product->rekap_DOpengiriman }}</span>{{ $product->category->productunit->name }}
                                @endif
                            </td>
                            <!-- DO terkirim -->
                            <td class="text-center">
                                @if ($product->rekap_DOterkirim > 0)
                                    <span class="badge bg-danger">{{ $product->rekap_DOterkirim }}</span>{{ $product->category->productunit->name }}
                                @else
                                    <span class="badge bg-success">{{ $product->rekap_DOterkirim }}</span>{{ $product->category->productunit->name }}
                                @endif
                            </td>
                            <!-- Rekap total produk selesai (lunas & terkirim) -->
                            <td class="text-center">
                                @if ($product->rekap_selesai > 0)
                                    <span class="badge bg-danger">{{ $product->rekap_selesai }}</span>{{ $product->category->productunit->name }}
                                @else
                                    <span class="badge bg-success">{{ $product->rekap_selesai }}</span>{{ $product->category->productunit->name }}
                                @endif
                            </td>
                            @endif
                        </tr>

                        @empty
                        <div class="alert text-white bg-danger" role="alert">
                            <div class="iq-alert-text">Data not Found.</div>
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
