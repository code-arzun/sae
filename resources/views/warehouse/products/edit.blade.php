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
                    <a href="{{ route('products.edit', $product->id) }}" class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div class="row d-flex flex-wrap align-items-center justify-content-between">
                    <div class="mr-3">
                        <h5>Edit Produk</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit Product</h4>
                    </div>
                </div> --}}

                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                        <!-- begin: Input Image -->
                            <div class="form-group row align-items-center">
                                <div class="col-md-12">
                                    <div class="profile-img-edit">
                                        <div class="crm-profile-img-edit">
                                            <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.webp') }}" alt="profile-pic">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-group mb-4 col-lg-6">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('product_image') is-invalid @enderror" id="image" name="product_image" accept="image/*" onchange="previewImage();">
                                        <label class="custom-file-label" for="product_image">Choose file</label>
                                    </div>
                                    @error('product_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        <!-- end: Input Image -->

                        <!-- begin: Input Data -->
                        <div class="row align-items-center">
                            <!-- Nama Produk -->
                            <div class="form-group col-md-12">
                                <label for="product_name">Nama Produk<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
                                @error('product_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Slug -->
                            {{-- @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin Publishing', 'Staf Publishing', 'Manajer Publishing'])) --}}
                            <div class="form-group col-md-12">
                                <label for="slug">Link <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2">{{ url('') }}/</span>
                                    </div>
                                    {{-- <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ url(old('slug', $product->slug)) }}" required readonly> --}}
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" readonly>
                                </div>
                                @error('slug')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {{-- @endif --}}
                            <!-- Kategori -->
                            <div class="form-group col-md-2">
                                <label for="category_id">Kategori<span class="text-danger">*</span></label>
                                <select class="form-control" name="category_id" required>
                                    <option selected="" disabled>-- Pilih Kategori --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Penerbit -->
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Sales', 'Manajer Marketing']))
                                <div class="form-group col-md-2">
                                    <label for="publisher_id">Penerbit <span class="text-danger">*</span></label>
                                        <select class="form-control" name="publisher_id">
                                            <option selected="" disabled>-- Pilih Penerbit --</option>
                                            @foreach ($publishers as $publisher)
                                                <option value="{{ $publisher->id }}" {{ old('publisher_id', $product->publisher_id) == $publisher->id ? 'selected' : '' }}>{{ $publisher->NamaPenerbit }}</option>
                                            @endforeach
                                        </select>
                                    @error('publisher_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            @endif
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin Publishing', 'Staf Publishing', 'Manajer Publishing']))
                            <!-- Penulis -->
                            <div class="form-group col-md-2">
                                <label for="writer_id">Penulis <span class="text-danger">*</span></label>
                                <select class="form-control" name="writer_id">
                                    <option selected="" disabled>-- Pilih Penulis --</option>
                                    @foreach ($writers as $writer)
                                        <option value="{{ $writer->id }}" {{ old('writer_id', $product->writer_id) == $writer->id ? 'selected' : '' }}>{{ $writer->NamaPenulis }}</option>
                                    @endforeach
                                </select>
                                @error('writer_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Jenis Cover -->
                            <div class="form-group col-md-2">
                                <label for="cover">Jenis Cover<span class="text-danger">*</span></label>
                                <select class="form-control @error('cover') is-invalid @enderror" name="cover">
                                    <option value="" selected disabled>-- Jenis Cover --</option>
                                    <option value="Soft Cover">Soft Cover</option>
                                    <option value="Hard Cover">Hard Cover</option>
                                </select>
                                @error('cover')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- ISBN -->
                            <div class="form-group col-md-4">
                                <label for="ISBN">No. ISBN<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    {{-- <input type="text"class="form-control text-center @error('ISBN') is-invalid @enderror" id="ISBN" name="ISBN" value="{{ old('ISBN') }}"  placeholder="XXX-602-XXXX-XX-X" aria-label="Ketebalan" aria-describedby="basic-addon2"> --}}
                                    {{-- <div class="d-flex align-items-center col-md" style="gap: 5px;" >
                                        <input class="form-control text-center col-md-2" type="text" id="isbn_part1" name="isbn_part1" maxlength="3" size="3" required oninput="moveFocus(this, 'isbn_part3')" value="{{ old('isbn1', $product->isbn1) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Angka pengenal produk terbitan buku dari EAN (Prefix identifier)" placeholder="000">
                                        <span>-</span>
                                        <input class="form-control text-center col-md-1" type="text" id="isbn_part2" name="isbn_part2" maxlength="3" size="3" required disabled value="602" value="{{ old('isbn2', $product->isbn2) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Kode kelompok / Kode negara">
                                        <span>-</span>
                                        <input class="form-control text-center col-md-3" type="text" id="isbn_part3" name="isbn_part3" maxlength="4" size="4" required oninput="moveFocus(this, 'isbn_part4')" value="{{ old('isbn3', $product->isbn3) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Kode penerbit (publisher prefix)"  placeholder="0000">
                                        <span>-</span>
                                        <input class="form-control text-center col-md-2" type="text" id="isbn_part4" name="isbn_part4" maxlength="2" size="2" required oninput="moveFocus(this, 'isbn_part5')" value="{{ old('isbn4', $product->isbn4) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Kode Judul (title identifier)" placeholder="00">
                                        <span>-</span>
                                        <input class="form-control text-center col-md-1" type="text" id="isbn_part5" name="isbn_part5" maxlength="1" size="1" required  value="{{ old('isbn5', $product->isbn5) }}"
                                        oninput="moveFocus(this, 'isbn_part5')" data-bs-toggle="tooltip" data-bs-placement="top" title="Angka pemeriksa (check digit)" placeholder="0">
                                    </div> --}}
                                    <input class="form-control text-center md-2" type="text" id="isbn_part1" name="isbn_part1" maxlength="3" size="3" required oninput="moveFocus(this, 'isbn_part3')" value="{{ old('isbn1', $product->isbn1) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Angka pengenal produk terbitan buku dari EAN (Prefix identifier)" placeholder="000">
                                        <input class="form-control text-center md-1" type="text" id="isbn_part2" name="isbn_part2" maxlength="3" size="3" required disabled value="602" value="{{ old('isbn2', $product->isbn2) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Kode kelompok / Kode negara">
                                        <input class="form-control text-center md-3" type="text" id="isbn_part3" name="isbn_part3" maxlength="4" size="4" required oninput="moveFocus(this, 'isbn_part4')" value="{{ old('isbn3', $product->isbn3) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Kode penerbit (publisher prefix)"  placeholder="0000">
                                        <input class="form-control text-center md-2" type="text" id="isbn_part4" name="isbn_part4" maxlength="2" size="2" required oninput="moveFocus(this, 'isbn_part5')" value="{{ old('isbn4', $product->isbn4) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Kode Judul (title identifier)" placeholder="00">
                                        <input class="form-control text-center md-1" type="text" id="isbn_part5" name="isbn_part5" maxlength="1" size="1" required  value="{{ old('isbn5', $product->isbn5) }}"
                                            oninput="moveFocus(this, 'published')" data-bs-toggle="tooltip" data-bs-placement="top" title="Angka pemeriksa (check digit)" placeholder="0">
                                </div>
                                @error('ISBN')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Terbit -->
                            <div class="form-group col-md-2">
                                <label for="published">Terbit</label>
                                <input id="published" class="form-control @error('published') is-invalid @enderror" name="published" value="{{ old('published', $product->published) }}">
                                {{-- <input id="published" class="form-control @error('published') is-invalid @enderror" name="published" value="{{ old('published', Carbon\Carbon::parse($product->product)->translatedformat('F Y')) }}" /> --}}
                                {{-- <input id="published" class="form-control @error('published') is-invalid @enderror" name="published" value="{{ Carbon\Carbon::parse($product->published)->format('m Y') : '-' }}" /> --}}
                                {{-- {{ Carbon\Carbon::parse($product->product)->translatedformat('d M Y') }} --}}
                                @error('published')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <!-- Halaman -->
                            <div class="form-group col-md-1">
                                <label for="page">Halaman<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    {{-- <div class="input-group-prepend">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">o</button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#" data-value="32">32</a>
                                            <a class="dropdown-item" href="#" data-value="40">40</a>
                                            <a class="dropdown-item" href="#" data-value="48">48</a>
                                            <a class="dropdown-item" href="#" data-value="56">56</a>
                                            <a class="dropdown-item" href="#" data-value="64">64</a>
                                            <a class="dropdown-item" href="#" data-value="72">72</a>
                                            <a class="dropdown-item" href="#" data-value="80">80</a>
                                            <a class="dropdown-item" href="#" data-value="96">96</a>
                                        </div>
                                      </div> --}}
                                    <input type="number" step="8" class="form-control text-center @error('page') is-invalid @enderror" id="page" name="page" value="{{ old('page', $product->page) }}"  placeholder="0" aria-label="Ketebalan" aria-describedby="basic-addon2">
                                </div>
                                @error('page')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @endif
                            <!-- Stok -->
                            <div class="form-group col-md-1">
                                <label for="product_store">Stok</label>
                                <input type="number" class="form-control text-center @error('product_store') is-invalid @enderror" id="product_store" min="0" name="product_store" value="{{ old('product_store', $product->product_store) }}" placeholder="0">
                                @error('product_store')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin Publishing', 'Staf Publishing', 'Manajer Publishing']))
                            <!-- Berat -->
                            <div class="form-group col-md-2">
                                <label for="weight">Berat<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.1" class="form-control text-center @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', $product->weight) }}"  placeholder="0" aria-label="Berat" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">gr</span>
                                    </div>
                                </div>
                                @error('weight')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Panjang -->
                            <div class="form-group col-md-2">
                                <label for="length">Panjang<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.1" class="form-control text-center @error('length') is-invalid @enderror" id="length" name="length" value="{{ old('length', $product->length) }}"  placeholder="0" aria-label="Panjang" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">cm</span>
                                    </div>
                                </div>
                                @error('length')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Lebar -->
                            <div class="form-group col-md-2">
                                <label for="width">Lebar<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.1" class="form-control text-center @error('width') is-invalid @enderror" id="width" name="width" value="{{ old('width', $product->width) }}"  placeholder="0" aria-label="Lebar" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">cm</span>
                                      </div>
                                </div>
                                @error('width')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Tebal -->
                            <div class="form-group col-md-2">
                                <label for="thickness">Tebal<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.1" class="form-control text-center @error('thickness') is-invalid @enderror" id="thickness" name="thickness" value="{{ old('thickness', $product->thickness) }}" placeholder="0" aria-label="Ketebalan" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                      <span class="input-group-text" id="basic-addon2">cm</span>
                                    </div>
                                </div>
                                @error('thickness')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @endif
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Admin Gudang']))
                            <!-- Tanggal Pembelian -->
                            <div class="form-group col-md-2">
                                <label for="buying_date">Tanggal Pembelian</label>
                                <input id="buying_date" class="form-control @error('buying_date') is-invalid @enderror" name="buying_date" value="{{ old('buying_date', $product->buying_date) }}" />
                                @error('buying_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Tanggal Kadaluwarsa -->
                            <div class="form-group col-md-2">
                                <label for="expire_date">Tanggal Kadaluwarsa</label>
                                <input id="expire_date" class="form-control @error('expire_date') is-invalid @enderror" name="expire_date" value="{{ old('expire_date', $product->expire_date) }}" />
                                @error('expire_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Harga Beli -->
                            <div class="form-group col-md-2">
                                <label for="buying_price">Harga Beli<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control text-center @error('buying_price') is-invalid @enderror" id="buying_price" name="buying_price" value="{{ old('buying_price', $product->buying_price) }}" placeholder="0">
                                </div>
                                @error('buying_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @endif
                            <!-- Harga Jual -->
                            <div class="form-group col-md-2">
                                <label for="selling_price">Harga 
                                    @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Sales', 'Manajer Marketing']))
                                    Jual
                                    @endif
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control text-center @error('selling_price') is-invalid @enderror" id="selling_price" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" placeholder="0">
                                </div>
                                @error('selling_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- Deskripsi -->
                        <div class="form-group col-md-12">
                            <label for="description">Deskripsi<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <textarea class="form-control file:@error('description') is-invalid @enderror" id="description" name="description" rows="10" placeholder="Belum ada deskripsi!">{{ old('description', $product->description) }}</textarea>
                            </div>
                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- end: Input Data -->
                </div>
                
                <div class="card-footer d-flex justify-content-end">
                    <a class="btn bg-danger me-2" href="{{ route('products.index') }}">Batalkan</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>

<script>
    $('#published').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'mm-yyyy'
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
</script>

@include('components.preview-img-form')
@endsection
