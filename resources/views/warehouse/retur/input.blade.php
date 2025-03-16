@extends('layout.main')

@section('specificpagestyles')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
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
                    <a href="{{ route('input.retur') }}" class="badge bg-secondary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div>
                    <h4 class="mb-3">Input Retur</h4>
                </div>
            </div>
        </div>

        <!-- Produk -->
        <div class="col-lg-5 col-md-12">
            <form action="#" method="get">
                <div class="d-flex flex-wrap align-items-center row">
                    <div class="col-sm-12 mb-3">
                        <select class="form-control delivery_id" name="delivery_id"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan SO" onchange="this.form.submit()">
                            <option selected="" disabled="">-- Pilih DO --</option>
                            <option value="" @if(request('delivery_id') == 'null') selected="selected" @endif>Semua</option>
                            @foreach ($deliveryOrders as $deliveryOrder)
                            <option value="{{ $deliveryOrder->id }}" {{ request('delivery_id') == $deliveryOrder->id ? 'selected' : '' }}>
                                {{ $deliveryOrder->invoice_no }} | {{ $deliveryOrder->salesorder->customer->NamaLembaga }} - 
                                {{ $deliveryOrder->salesorder->customer->NamaCustomer }} | Rp {{ number_format($deliveryOrder->sub_total) }} | {{ $deliveryOrder->salesorder->customer->employee->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
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
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td class="text-left"  data-bs-toggle="tooltip" data-bs-placement="top" title="" title="{{ $product->category->name }} Rp {{ $product->selling_price }}">
                                <b>{{ $product->product_name }}</b> {{-- {{ $product->category->name }} --}}
                            </td>
                            <td>
                                <form action="{{ route('inputretur.addCart') }}" method="POST"  style="margin-bottom: 5px">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <input type="hidden" name="name" value="{{ $product->product_name }}">
                                    <input type="hidden" name="category" value="{{ $product->category->name }}">
                                    <input type="hidden" name="price" value="{{ $product->selling_price }}">
                                    <button type="submit" class="btn btn-primary border-none" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Tambah ke daftar pesanan"><i class="far fa-plus me-0"></i></button>
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
        <div class="col-lg-7 col-md-12">
            <table class="table">
                <thead>
                    <tr class="light text-center">
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th width="5px">Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productItem as $item)
                    <tr>
                        <td class="text-center">
                            <a href="{{ route('inputretur.deleteCart', $item->rowId) }}" class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Hapus"><i class="fa-solid fa-trash me-0"></i></a>
                        </td>
                        <td><b>{{ $item->name }}</b>
                            <p>{{ $item->category }}</p>
                        </td>
                        <td style="min-width: 140px;">
                            <form action="{{ route('inputretur.updateCart', $item->rowId) }}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="number" class="form-control text-center" name="qty" required
                                        value="{{ old('qty', $item->qty) }}" onblur="this.form.submit()">
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
                    <form action="{{ route('inputretur.confirmation') }}" method="POST">
                        @csrf
                        <tr>
                            <th class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Gunakan titik (.) sebagai pemisah!">Diskon (%)</th>
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

            <form action="{{ route('inputretur.confirmation') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-md" hidden>
                        <label for="delivery_id">Delivery Order</label>
                        <select class="form-control delivery_id bg-white" name="delivery_id" id="delivery_id">
                            <option selected="" disabled="">-- Pilih DO --</option>
                            <option value="" @if(request('delivery_id') == 'null') selected="selected" @endif>Semua</option>
                            @foreach ($deliveryOrders as $deliveryOrder)
                            <option value="{{ $deliveryOrder->id }}" {{ request('delivery_id') == $deliveryOrder->id ? 'selected' : '' }}>
                                {{ $deliveryOrder->invoice_no }} | {{ $deliveryOrder->salesorder->customer->NamaLembaga }} - 
                                {{ $deliveryOrder->salesorder->customer->NamaCustomer }} | Rp {{ number_format($deliveryOrder->sub_total) }} | {{ $deliveryOrder->salesorder->customer->employee->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('delivery_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-success w-100"><b>Buat Retur</b></button>
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
