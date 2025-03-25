@extends('layout.main')

@section('specificpagestyles')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('container')

<div class="d-flex justify-content-between mb-3">
    <div>
        <h2>{{ $title }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-default-icon">
                @include('warehouse.products.partials.breadcrumb')
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('products.show', $product->id) }}">Detail Produk</a></li>
            </ol>
        </nav>
    </div>
    <div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <img src="{{ $product->product_image ? asset($product->product_image) : asset(Storage::url('products/default.png')) }}" alt="{{ $product->product_name }}" class="img-fluid">
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body row d-flex justify-content-between">
                <!-- Nama Produk -->
                <div class="form-group col-md-12">
                    <label class="text-muted mb-1">Nama Produk</label>
                    <h4>{{  $product->product_name }}</h4>
                </div>
                <!-- Kode -->
                <div class="form-group col-md">
                    <label class="text-muted mb-1">Kode Produk</label>
                    <h5>{{  $product->product_code }}</h5>
                </div>
                <!-- Barcode -->
                <div class="form-group col-md">
                    <label class="text-muted mb-1">Barcode</label>
                    {!! $barcode !!}
                </div>
                <!-- Kategori -->
                <div class="form-group col-md">
                    <label class="text-muted mb-1">Kategori</label>
                    <h5>{{  $product->category->name }}</h5>
                </div>
                <!-- Slug -->
                <div class="form-group col-md-12">
                    <label class="text-muted mb-1">Link</label>
                    <div class="input-group">
                        <input type="text" id="productLink" class="form-control" value="{{ url($product->slug) }}" readonly>
                        <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard()"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Salin link ke clipboard.">
                            Salin
                        </button>
                    </div>
                </div>
                <div class="row justify-content-between">
                    @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Sales', 'Manajer Marketing']))
                    <!-- Penerbit -->
                    <div class="form-group col-md">
                        <label class="text-muted mb-1">Penerbit</label>
                        <h5>{{  $product->publisher->NamaPenerbit ?? '-' }}</h5>
                    </div>
                    @endif
                    @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin Publishing', 'Staf Publishing', 'Manajer Publishing']))
                    <!-- Penerbit -->
                    <div class="form-group col-md">
                        <label class="text-muted mb-1">Penulis</label>
                        <h5>{{ $product->writer->NamaPenulis ?? '-' }}</h5>
                    </div>
                    <!-- Cover -->
                    <div class="form-group col-md">
                        <label class="text-muted mb-1">Cover</label>
                        <h5>{{ $product->cover ?? '-' }}</h5>
                    </div>
                    <!-- Terbit -->
                    <div class="form-group col-md">
                        <label class="text-muted mb-1">Terbit</label>
                        <h5>{{ Carbon\Carbon::parse($product->product)->translatedformat('F Y') }}</h5>
                    </div>
                    <!-- ISBN -->
                    <div class="form-group col-md">
                        <label class="text-muted mb-1">ISBN</label>
                        <h5>{{ $product->isbn1 ?? '-' }} - {{ $product->isbn2 ?? '-' }} - {{ $product->isbn3 ?? '-' }} - {{ $product->isbn4 ?? '-' }} - {{ $product->isbn5 ?? '-' }}</h5>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <!-- Halaman -->
                    <div class="form-group col-md">
                        <label class="text-muted mb-1">Halaman</label>
                        <h5>{{ $product->page ?? '-' }}</h5>
                    </div>
                    <!-- Panjang -->
                    <div class="form-group col-md">
                        <label class="text-muted mb-1">Panjang</label>
                        <h5>{{ $product->length ?? '-' }} <span class="text-secondary">cm</span></h5>
                    </div>
                    <!-- Lebar -->
                    <div class="form-group col-md">
                        <label class="text-muted mb-1">Lebar</label>
                        <h5>{{ $product->width ?? '-' }} <span class="text-secondary">cm</span></h5>
                    </div>
                    <!-- Ketebalan -->
                    <div class="form-group col-md">
                        <label class="text-muted mb-1">Ketebalan</label>
                        <h5>{{ $product->thickness ?? '-' }} <span class="text-secondary">cm</span></h5>
                    </div>
                    <!-- Berat -->
                    <div class="form-group col-md">
                        <label class="text-muted mb-1">Berat</label>
                        <h5>{{ $product->weight ?? '-' }} <span class="text-secondary">cm</span></h5>
                    </div>
                    @endif
                </div>
                
                <!-- Deskripsi -->
                <div class="form-group col-md-12">
                    <label class="text-muted mb-1" for="description">Deskripsi<span class="text-danger">*</span></label>
                    <h5>{{ $product->description ?? '-' }}</h5>
                </div>
            </div>
        </div>
        <div class="row justify-content-start">
            <!-- Stok -->
            <div class="form-group col-md">
                <div class="card">
                    <div class="card-body">
                        <label class="text-muted mb-1">Stok</label>
                        <h5>{{  $product->product_store }} <span class="text-secondary">{{  $product->category->productunit->name }}</span></h5>
                    </div>
                </div>
            </div>
            @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Manajer Marketing']))
            <!-- Harga Beli -->
            <div class="form-group col-md">
                <div class="card">
                    <div class="card-body">
                        <label class="text-muted mb-1">Harga Beli</label>
                        <h5><span class="text-secondary">Rp </span>{{  number_format($product->buying_price) }}</h5>
                    </div>
                </div>
            </div>
            @endif
            <!-- Harga Jual -->
            <div class="form-group col-md">
                <div class="card">
                    <div class="card-body">
                        <label class="text-muted mb-1">Harga
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Manajer Marketing']))
                            Jual
                            @endif
                        </label>
                        <h5><span class="text-secondary">Rp </span>{{  number_format($product->selling_price) }}</h5>
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
