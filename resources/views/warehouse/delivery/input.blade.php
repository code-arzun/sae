@extends('layout.main')

@section('specificpagestyles')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('container')
<div class="container-fluid">
    <div class="row">
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
        <div class="col-lg-12 d-flex flex-wrap align-items-top justify-content-between">
            <div>
                <a href="{{ url()->previous() }}" class="badge bg-primary mb-3 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left mb-1 mt-1"></i></a>
                <a href="{{ route('input.do') }}" class="badge bg-secondary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
            </div>
            <div>
                <h4 class="mb-3">Input Delivery Order</h4>
            </div>
        </div>

        <!-- Produk -->
        <div class="col-lg-6 col-md-12">
            <form action="#" method="get">
                <div class="d-flex flex-wrap align-items-center row">
                    <!-- Filter berdasarkan SO -->
                        <div class="col-sm-12 mb-3">
                            <select class="form-control order_id" name="order_id"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan SO" onchange="this.form.submit()">
                                <option selected="" disabled="">-- Pilih SO --</option>
                                <option value="" @if(request('order_id') == 'null') selected="selected" @endif>Semua</option>
                                @foreach ($salesorders as $salesorder)
                                    <option value="{{ $salesorder->id }}" {{ request('order_id') == $salesorder->id ? 'selected' : '' }}>
                                        {{ $salesorder->invoice_no }} | {{ $salesorder->customer->NamaLembaga }} - 
                                        {{ $salesorder->customer->NamaCustomer }} | Rp {{ $salesorder->sub_total }} | {{ $salesorder->customer->employee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
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
            <div class="dt-responsive table-responsive mb-3 border-none">
                <table class="table table-striped table-bordered nowrap mb-0">
                    <thead>
                        <tr>
                            <th>@sortablelink('product_name', 'Nama Produk')</th>
                            <th>@sortablelink('category', 'Kategori')</th>
                            <th>@sortablelink('selling_price', 'Harga')</th>
                            <th>Dipesan</th>
                            <th>Terkirim</th>
                            <th>Dikirim</th>
                            <th>Belum dikirim</th>
                            <th>@sortablelink('stock', 'Stok')</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td class="text-left" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="{{ $product->category->name }} || Rp {{ number_format($product->selling_price) }}">
                                <b >{{ $product->product_name }}</b>
                            </td>
                            <td class="text-left">
                                {{ $product->category->name }}
                            </td>
                            <td class="text-end">
                                Rp {{ number_format($product->selling_price) }}
                            </td>
                            <td class="text-center">
                                @if ($product->filteredOrderDetail)
                                    {{-- @if ($product->filteredOrderDetail->quantity > 100)
                                            <span class="badge bg-success">{{ number_format($product->filteredOrderDetail->quantity) }}</span>
                                        @elseif ($product->filteredOrderDetail->quantity >= 50 && $product->filteredOrderDetail->quantity <= 99)
                                            <span class="badge bg-warning">{{ number_format($product->filteredOrderDetail->quantity) }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ number_format($product->filteredOrderDetail->quantity) }}</span>
                                    @endif --}}
                                    <span class="badge bg-purple">{{ number_format($product->filteredOrderDetail->quantity) }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($product->filteredOrderDetail)
                                    @if ($product->filteredOrderDetail->delivered === $product->filteredOrderDetail->quantity)
                                        <span class="badge bg-success">{{ number_format($product->filteredOrderDetail->delivered) }}</span>
                                    @elseif ($product->filteredOrderDetail->delivered > 0 && $product->filteredOrderDetail->delivered < $product->filteredOrderDetail->quantity)
                                        <span class="badge bg-primary">{{ number_format($product->filteredOrderDetail->delivered) }}</span>
                                    @else
                                        
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($product->filteredOrderDetail)
                                    @if ($product->filteredOrderDetail->sent === $product->filteredOrderDetail->quantity)
                                        <span class="badge bg-success">{{ number_format($product->filteredOrderDetail->sent) }}</span>
                                    @elseif ($product->filteredOrderDetail->sent > 0 && $product->filteredOrderDetail->sent < $product->filteredOrderDetail->quantity)
                                        <span class="badge bg-primary">{{ number_format($product->filteredOrderDetail->sent) }}</span>
                                    @else
                                        
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($product->filteredOrderDetail)
                                    @if ($product->filteredOrderDetail->to_send === $product->filteredOrderDetail->quantity)
                                        <span class="badge bg-danger">{{ number_format($product->filteredOrderDetail->to_send) }}</span>
                                    @elseif ($product->filteredOrderDetail->to_send > 0 && $product->filteredOrderDetail->to_send < $product->filteredOrderDetail->quantity)
                                        <span class="badge bg-secondary">{{ number_format($product->filteredOrderDetail->to_send) }}</span>
                                    @else
                                        
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($product->product_store > 100)
                                    <span class="badge bg-success">{{number_format($product->product_store) }}</span>
                                @elseif ($product->product_store >= 50 && $product->product_store <= 99)
                                    <span class="badge bg-warning">{{number_format($product->product_store) }}</span>
                                @else
                                    <span class="badge bg-danger">{{number_format($product->product_store) }}</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('inputdo.addCart') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <input type="hidden" name="name" value="{{ $product->product_name }}">
                                    <input type="hidden" name="category" value="{{ $product->category->name }}">
                                    <input type="hidden" name="price" value="{{ $product->selling_price }}">
                                    @if ($product->product_store > 0 && optional($product->filteredOrderDetail)->delivered < optional($product->filteredOrderDetail)->quantity)
                                        <button type="submit" class="btn badge-primary border-none" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Tambah ke daftar pesanan"><i class="far fa-plus me-0"></i></button>
                                    @else
                                    @endif
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

        <!-- Cart -->
        <div class="col-lg-6 col-md-12 mb-5">
            <!-- Detail Pesanan -->
            <table class="table table-striped table-bordered nowrap">
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
                            <a href="{{ route('inputdo.deleteCart', $item->rowId) }}" class="btn btn-warning border-none" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Hapus"><i class="fa-solid fa-trash me-0"></i></a>
                        </td>
                        <td data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Rp {{ number_format($item->price) }}">
                            <b>{{ $item->name }}</b> <br>
                            {{-- {{ $item->category }} --}}
                        </td>
                        <td><i>{{ $item->category }}</i></td>
                        <td>
                            <form action="{{ route('inputdo.updateCart', $item->rowId) }}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="number" class="form-control text-center" style="width:100px" name="qty" required
                                        value="{{ old('qty', $item->qty) }}" 
                                        onblur="validateQuantity(this)">
                                </div>
                            </form>
                        </td>
                        <td class="text-end">Rp {{ number_format($item->price) }}</td>
                        <td class="text-end">Rp {{ number_format($item->subtotal) }}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
                
            <!-- Total -->
            <table class="table">
                <tbody class="light text-end">
                    <th>Total Item<span class="badge bg-secondary ml-3">{{ number_format(count(Cart::content())) }}</span></th>
                    <th>Total Barang<span class="badge bg-primary ml-3">{{ number_format(Cart::count()) }}</span></th>
                    <th>Subtotal<span class="badge bg-success ml-3">Rp {{ number_format(Cart::subtotal()) }}</span></th>
                </tbody>
            </table>

            <form action="{{ route('inputdo.confirmation') }}" method="POST">
                @csrf
                <div class="row mt-3">
                    {{-- <div class="form-group col-md-3">
                        <label for="order_date">Tanggal Pemesanan</label>
                        <input id="order_date" class="form-control @error('order_date') is-invalid @enderror" name="order_date" value="{{ old('order_date') }}" />
                        @error('order_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div> --}}
                    <!-- SO -->
                    <div class="form-group col-md" hidden>
                        <label for="order_id">Sales Order</label>
                        <select class="form-control order_id" name="order_id">
                            <option selected="" disabled="">-- Pilih SO --</option>
                            @foreach ($salesorders as $salesorder)
                                <option value="{{ $salesorder->id }}" {{ request('order_id') == $salesorder->id ? 'selected' : '' }}>
                                    {{ $salesorder->invoice_no }} | {{ $salesorder->customer->NamaLembaga }} - 
                                    {{ $salesorder->customer->NamaCustomer }} | Rp {{ $salesorder->sub_total }} | {{ $salesorder->customer->employee->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('order_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-success w-100"><h5>Buat Delivery Order</h5></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#order_date').datepicker({
        uiLibrary: 'bootstrap4',
        // format: 'dd-mm-yyyy'
        format: 'yyyy-mm-dd'
        // https://gijgo.com/datetimepicker/configuration/format
    });
</script>

{{-- @include('components.preview-img-form') --}}
@endsection
