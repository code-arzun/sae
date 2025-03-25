<div id="editProduk{{ $product->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white" id="editProdukLabel">Edit {{ $title }}</h3>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
            </div>
            <div class="modal-body bg-gray-100">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <!-- begin: Input Image -->
                        <div class="form-group row align-items-center">
                            <div class="col-md-12">
                                <div class="profile-img-edit">
                                    <div class="crm-profile-img-edit">
                                        <img class="crm-profile-pic avatar-100" id="image-preview" src="{{ asset('storage/product/default.png') }}" alt="profile-pic">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group mb-4 col-lg-6">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('product_image') is-invalid @enderror" id="product_image" name="product_image" accept="image/*" onchange="previewImage();">
                                    <label class="custom-file-label" for="product_image">Pilih file</label>
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
                        <div class="form-group col-md-12">
                            <label for="slug">Link <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2">{{ url('') }}/</span>
                                </div>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" required readonly>
                            </div>
                            @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Kategori -->
                        <div class="form-group col-md-2">
                            <label for="category_id">Kategori<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" required>
                                    <option selected="" disabled>-- Pilih Kategori --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Sales', 'Manajer Marketing']))
                                <div class="input-group-append">
                                    <a class="input-group-text bg-primary" href="{{ route('productcategory.create') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Kategori"><i class="fa fa-plus"></i></a>
                                </div>
                                @endif
                            </div>
                            @error('category_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Sales', 'Manajer Marketing']))
                        <!-- Penerbit -->
                        <div class="form-group col-md-2">
                            <label for="publisher_id">Penerbit <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select class="form-control @error('published_id') is-invalid @enderror" name="publisher_id" required>
                                    <option selected="" disabled>-- Pilih Penerbit --</option>
                                    @foreach ($publishers as $publisher)
                                        <option value="{{ $publisher->id }}" {{ old('publisher_id') == $publisher->id ? 'selected' : '' }}>{{ $publisher->NamaPenerbit }}</option>
                                    @endforeach
                                </select>
                                @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Sales', 'Manajer Marketing']))
                                <div class="input-group-append">
                                    <a class="input-group-text bg-primary" href="{{ route('publisher.create') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Penerbit"><i class="fa fa-plus"></i></a>
                                </div>
                                @endif
                            </div>
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
                            <select class="form-control @error('writer_id') is-invalid @enderror"  name="writer_id" required>
                                <option selected="" disabled>-- Pilih Penulis --</option>
                                @foreach ($writers as $writer)
                                    <option value="{{ $writer->id }}" {{ old('writer_id') == $writer->id ? 'selected' : '' }}>{{ $writer->NamaPenulis }}</option>
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
                            <select class="form-control @error('cover') is-invalid @enderror" name="cover" required>
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
                                <input class="form-control text-center md-2" type="text" id="isbn1" name="isbn1" maxlength="3" size="3" value="{{ old('isbn1', $product->isbn1) }}" required oninput="moveFocus(this, 'isbn3')"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Angka pengenal produk terbitan buku dari EAN (Prefix identifier)" placeholder="000">
                                <input class="form-control text-center md-1" type="text" id="isbn2" name="isbn2" maxlength="3" size="3" required readonly value="602"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Kode kelompok / Kode negara">
                                <input class="form-control text-center md-3" type="text" id="isbn3" name="isbn3" maxlength="4" size="4" value="{{ old('isbn3', $product->isbn3) }}" required oninput="moveFocus(this, 'isbn4')"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Kode penerbit (publisher prefix)"  placeholder="0000">
                                <input class="form-control text-center md-2" type="text" id="isbn4" name="isbn4" maxlength="2" size="2" value="{{ old('isbn4', $product->isbn4) }}" required oninput="moveFocus(this, 'isbn5')"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Kode Judul (title identifier)" placeholder="00">
                                <input class="form-control text-center md-1" type="text" id="isbn5" name="isbn5" maxlength="1" size="1" value="{{ old('isbn5', $product->isbn5) }}" required 
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
                            <input id="published" class="form-control @error('published') is-invalid @enderror" name="published" value="{{ old('published', $product->published) }}" required>
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
                            <input type="number" class="form-control text-center @error('product_store') is-invalid @enderror" id="product_store" min="0" name="product_store" value="{{ old('product_store', $product->product_store) }}" placeholder="0" required>
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
                                <input type="number" step="0.1" class="form-control text-center @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', $product->weight) }}"  placeholder="0" aria-label="Berat" aria-describedby="Berat">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="Berat">gr</span>
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
                        <!-- Deskripsi -->
                        <div class="form-group col-md-12">
                            <label for="description">Deskripsi<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description') }}"
                                    rows="3">
                                    {{ $product->description }}
                                </textarea>
                            </div>
                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- end: Input Data -->
                </div> 
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
  </div>