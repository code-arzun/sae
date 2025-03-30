@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit Type</h4>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('type.update', $cashflowtype->id) }}" method="POST">
                    @csrf
                    @method('put')
                        <!-- begin: Input Data -->
                        <div class=" row align-items-center">
                            <div class="form-group col-md-12">
                                <label for="type">Jenis<span class="text-danger">*</span></label>
                                <select class="form-control" name="cashflowcategory" required>
                                    <option selected="" disabled>-- Pilih Jenis Transaksi--</option>
                                    <option value="{{ $cashflowtype->id }}" {{ old('id', $cashflowtype->id) == $cashflowtype->id ? 'selected' : '' }} disabled>{{ $cashflowtype->type }}</option>
                                    <option value="Pemasukan">Pemasukan</option>
                                    <option value="Pengeluaran">Pengeluaran</option>
                                </select>
                                @error('cashflowcategory')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="category">Kategori<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category', $cashflowtype->category) }}" required>
                                @error('category')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="detail">Keterangan<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail" value="{{ old('detail', $cashflowtype->detail) }}" required>
                                @error('detail')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- end: Input Data -->
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Simpan</button>
                            <a class="btn bg-danger" href="{{ route('type.index') }}">Batalkan</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>


@include('components.preview-img-form')
@endsection
