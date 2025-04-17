    <!-- Filter -->
    <form action="" method="get">
        <div class="d-flex flex-wrap align-items-center row">
            <!-- Jenjang -->
                <div class="col-sm-3 mb-3">
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
                <div class="col-sm-3 mb-3">
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
            <!-- Kategori -->
                <div class="col-sm-3 mb-3">
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
            <!-- Mata Pelajaran -->
                <div class="col-sm-3 mb-3">
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
            {{-- <div class="form-group col-sm-4">
                <input type="text" id="search" class="form-control" name="search" placeholder="Cari Produk" value="{{ request('search') }}" onkeyup="this.form.submit()">
            </div> --}}
        </div>
    </form>

    <!-- Daftar Produk -->
    <div class="dt-responsive table-responsive">
        <table class="table nowrap mb-0">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th width="100px">Harga</th>
                    {{-- <th data-bs-toggle="tooltip" data-bs-placement="top" title="Jumlah yang dipesan"><i class="ti ti-shopping-cart"></i></th> --}}
                    <th data-bs-toggle="tooltip" data-bs-placement="top" title="Jumlah yang terkirim"><i class="fas fa-check"></i></th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td><strong>{{ $product->product_name }}</strong></td>
                    <td>{{ $product->category->name }}</td>
                    <td class="accounting price">{{ number_format($product->selling_price) }}</td>
                    <th data-bs-toggle="tooltip" data-bs-placement="top" title="Jumlah yang dipesan">
                        @if ($product->filteredOrderDetail)
                            <span class="text-secondary">{{ number_format($product->filteredOrderDetail->quantity) }}</span>
                        @endif
                    </th>
                    {{-- <th data-bs-placement="top" title="Jumlah yang terkirim">
                        @if ($product->filteredOrderDetail)
                            @if ($product->filteredOrderDetail->delivered === $product->filteredOrderDetail->quantity)
                                <span class="text-success">{{ number_format($product->filteredOrderDetail->delivered) }}</span>
                            @elseif ($product->filteredOrderDetail->delivered > 0 && $product->filteredOrderDetail->delivered < $product->filteredOrderDetail->quantity)
                                <span class="text-primary">{{ number_format($product->filteredOrderDetail->delivered) }}</span>
                            @else
                                -
                            @endif
                        @endif
                    </th> --}}
                   
                    <form action="{{ route('inputretur.addCart') }}" method="POST">
                        @csrf
                        <td class="text-center">
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->product_name }}">
                            <input type="hidden" name="category" value="{{ $product->category->name }}">
                            <input type="hidden" name="price" value="{{ $product->selling_price }}">
                            <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah ke daftar pesanan"><i class="ti ti-plus"></i></button>
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
    </div>