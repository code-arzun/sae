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
            <div class="col d-flex flex-wrap align-items-center justify-content-between mb-3">
                <div class="row">
                    <a href="{{ url()->previous() }}" class="badge bg-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left mb-1 mt-1"></i></a>
                    <a href="{{ route('products.show', $product->id) }}" class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div class="row d-flex flex-wrap align-items-center justify-content-between">
                    <div class="mr-3">
                        <h5>Informasi Detail Produk</h5>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <img class="crm-profile-pic" id="image-preview" src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.webp') }}" alt="profile-pic">
                </div>
            </div>
        </div> --}}

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Kode -->
                        <div class="form-group col-md-4">
                            <label>Kode Produk</label>
                            <input type="text" class="form-control bg-white" value="{{  $product->product_code }}" readonly>
                        </div>
                        <!-- Barcode -->
                        <div class="form-group col-md-4">
                            <label>Barcode</label>
                            {!! $barcode !!}
                        </div>
                        <!-- Nama Produk -->
                        <div class="form-group col-md-12">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control bg-white" value="{{  $product->product_name }}" readonly>
                        </div>
                        <!-- Slug -->
                        <div class="form-group col-md-12">
                            <label>Link</label>
                            <div class="input-group">
                                <input type="text" id="productLink" class="form-control bg-white" value="{{ url($product->slug) }}" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" onclick="copyToClipboard()"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Salin link ke clipboard.">Salin</button>
                                </div>
                            </div>
                        </div>
                        <!-- Kategori -->
                        <div class="form-group col-md-4">
                            <label>Kategori</label>
                            <input type="text" class="form-control bg-white" value="{{  $product->category->name }}" readonly>
                        </div>
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Sales', 'Manajer Marketing']))
                        <!-- Penerbit -->
                        <div class="form-group col-md-4">
                            <label>Penerbit</label>
                            <input type="text" class="form-control bg-white" value="{{  $product->publisher->NamaPenerbit ?? '-' }}" readonly>
                        </div>
                        @endif
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin Publishing', 'Staf Publishing', 'Manajer Publishing']))
                        <!-- Penerbit -->
                        <div class="form-group col-md-4">
                            <label>Penulis</label>
                            <input type="text" class="form-control bg-white" value="{{ $product->writer->NamaPenulis ?? '-' }}" readonly>
                        </div>
                        <!-- Cover -->
                        <div class="form-group col-md-4">
                            <label>Cover</label>
                            <input type="text" class="form-control bg-white" value="{{ $product->cover ?? '-' }}" readonly>
                        </div>
                        <!-- Terbit -->
                        <div class="form-group col-md-4">
                            <label>Terbit</label>
                            <input id="published" class="form-control bg-white" name="published" value="{{ Carbon\Carbon::parse($product->product)->translatedformat('F Y') }}" readonly>
                            {{-- <input type="text" class="form-control bg-white" value="{{ $product->published ?? '-' }}" readonly> --}}
                        </div>
                        <!-- ISBN -->
                        <div class="form-group col-md-4">
                            <label>ISBN</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-center bg-white" value="{{ $product->isbn1 ?? '-' }}" readonly
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Angka pengenal produk terbitan bukudari EAN (Prefix identifier)">
                                <input type="text" class="form-control text-center bg-white" value="{{ $product->isbn2 ?? '-' }}" readonly
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Kode kelompok / Kode negara">
                                <input type="text" class="form-control text-center bg-white" value="{{ $product->isbn3 ?? '-' }}" readonly
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Kode penerbit (publisher prefix)">
                                <input type="text" class="form-control text-center bg-white" value="{{ $product->isbn4 ?? '-' }}" readonly
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Kode Judul (title identifier)">
                                <input type="text" class="form-control text-center bg-white" value="{{ $product->isbn5 ?? '-' }}" readonly
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Angka pemeriksa (check digit)">
                            </div>
                        </div>
                        <!-- Halaman -->
                        <div class="form-group col-md-4">
                            <label>Halaman</label>
                            <input type="text" class="form-control bg-white" value="{{ $product->page ?? '-' }}" readonly>
                        </div>
                        <!-- Panjang -->
                        <div class="form-group col-md-4">
                            <label>Panjang</label>
                            <div class="input-group">
                                <input type="text" class="form-control bg-white" value="{{ $product->length ?? '-' }}" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">cm</span>
                                </div>
                            </div>
                        </div>
                        <!-- Lebar -->
                        <div class="form-group col-md-4">
                            <label>Lebar</label>
                            <div class="input-group">
                                <input type="text" class="form-control bg-white" value="{{ $product->width ?? '-' }}" readonly>
                                <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">cm</span>
                                </div>
                            </div>
                        </div>
                        <!-- Ketebalan -->
                        <div class="form-group col-md-4">
                            <label>Ketebalan</label>
                            <div class="input-group">
                                <input type="text" class="form-control bg-white" value="{{ $product->thickness ?? '-' }}" readonly>
                                <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">cm</span>
                                </div>
                            </div>
                        </div>
                        <!-- Berat -->
                        <div class="form-group col-md-4">
                            <label>Berat</label>
                            <div class="input-group">
                                <input type="text" class="form-control bg-white" value="{{ $product->weight ?? '-' }}" readonly>
                                <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">gr</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- Stok -->
                        <div class="form-group col-md-4">
                            <label>Stok</label>
                            <div class="input-group">
                                <input type="text" class="form-control bg-white" value="{{  $product->product_store }}" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">{{  $product->category->productunit->name }}</span>
                                </div>
                            </div>
                        </div>
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Sales', 'Manajer Marketing']))
                        <!-- Jumlah dipesan -->
                        <div class="form-group col-md-4">
                            <label>Jumlah Dipesan</label>
                            <div class="input-group">
                                <input type="text" class="form-control bg-white" value="{{  $product->product_ordered }}" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">{{  $product->category->productunit->name }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- Kekurangan Stok -->
                        <div class="form-group col-md-4">
                            <label>Stok dibutuhkan</label>
                            <div class="input-group">
                                <input type="text" class="form-control bg-white" value="{{  $product->stock_needed }}" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">{{  $product->category->productunit->name }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- Harga Beli -->
                        <div class="form-group col-md-4">
                            <label>Harga Beli</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control bg-white" value="{{  number_format($product->buying_price) }}" readonly>
                            </div>
                        </div>
                        @endif
                        <!-- Harga Jual -->
                        <div class="form-group col-md-4">
                            <label>Harga
                                @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Sales', 'Manajer Marketing']))
                                Jual
                                @endif
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control bg-white" value="{{  number_format($product->selling_price) }}" readonly>
                            </div>
                        </div>
                        <!-- Deskripsi -->
                        <div class="form-group col-md-12">
                            <label for="description">Deskripsi<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <textarea class="form-control bg-white" id="description" name="description" rows="10" readonly>{{ $product->description ?? '-' }}</textarea>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
    function copyToClipboard() {
        var copyText = document.getElementById("productLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999); // Untuk perangkat mobile
        document.execCommand("copy");

        // Menggunakan SweetAlert sebagai toast notification
        Swal.fire({
            toast: true,
            icon: 'success',
            title: 'Link berhasil disalin!',
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            // timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    }
</script>

@include('components.preview-img-form')
@endsection
