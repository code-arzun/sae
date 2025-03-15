@extends('layout.main')

@section('container')
<div class="row container-fluid">
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
            <a href="{{ route('input.so') }}" class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
        </div>
        <div>
            <h4>Input Sales Order</h4>
        </div>
    </div>
    <!-- Produk -->
    {{-- <div class="col-lg-5 col-md-12"> --}}
    <div class="col-lg-7 col-md-12">
        <!-- Pencarian & Filter -->
        <form id="productForm">
            <div id="productContainer">
                <div class="product-input">
                    <label for="productName1">Nama Produk:</label>
                    <input type="text" name="productName[]" id="productName1" placeholder="Masukkan nama produk" required>
                    
                    <label for="productQuantity1">Jumlah:</label>
                    <input type="number" name="productQuantity[]" id="productQuantity1" placeholder="Masukkan jumlah" required min="1">
                    
                    <button type="button" class="removeProduct">Hapus</button>
                </div>
            </div>
            <button type="button" id="addProduct">+ Tambah Produk</button>
            <button type="submit">Simpan</button>
        </form>
    </div>
    
    <!-- Cart -->
    <div class="col-lg-5 col-md-12">
    {{-- <div class="col-lg-7 col-md-12"> --}}
        <table class="table">
            <thead>
                <tr class="light text-center">
                    <th>#</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th width="5px">Jumlah</th>
                    <th width="100px">Harga</th>
                    <th width="150px">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productItem as $item)
                <tr>
                    <td class="text-center">
                        <a href="{{ route('inputso.deleteCart', $item->rowId) }}" class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Hapus"><i class="fa-solid fa-trash me-0"></i></a>
                    </td>
                    <td><b>{{ $item->name }}</b></td>
                    <td>{{ $item->category }}</td>
                    <td>
                        <form action="{{ route('inputso.updateCart', $item->rowId) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="number" class="form-control text-center" style="width:70px" name="qty" required
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
                    <select class="form-control select2" id="customer_id" name="customer_id">
                        <option selected="" disabled="">-- Customer --</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->NamaLembaga }} | {{ $customer->NamaCustomer }} - {{ $customer->Jabatan }}
                                @if (auth()->user()->hasAnyRole('Super Admin', 'Manajer Marketing', 'Admin'))
                                | {{  $customer->employee->name }}</option>
                                @endif 
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
    document.getElementById('addProduct').addEventListener('click', function() {
    const container = document.getElementById('productContainer');
    const count = container.getElementsByClassName('product-input').length + 1;

    // Buat div baru untuk input nama produk dan jumlah
    const newInput = document.createElement('div');
    newInput.classList.add('product-input');
    newInput.innerHTML = `
        <label for="productName${count}">Nama Produk:</label>
        <input type="text" name="productName[]" id="productName${count}" placeholder="Masukkan nama produk" required>
        
        <label for="productQuantity${count}">Jumlah:</label>
        <input type="number" name="productQuantity[]" id="productQuantity${count}" placeholder="Masukkan jumlah" required min="1">
        
        <button type="button" class="removeProduct">Hapus</button>
    `;

    container.appendChild(newInput);
});

// Hapus elemen input
document.getElementById('productForm').addEventListener('click', function(e) {
    if (e.target.classList.contains('removeProduct')) {
        e.target.parentElement.remove();
    }
});

</script>