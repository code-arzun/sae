@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Create Category</h4>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('category.store') }}" method="POST">
                    @csrf
                        <!-- begin: Input Data -->
                        <div class=" row align-items-center">
                            <div class="form-group col-md-12">
                                <label for="cashflowtype_id">Jenis Transaksi<span class="text-danger">*</span></label>
                                <select class="form-control" name="cashflowtype_id" required>
                                    <option selected="" disabled>-- Pilih Jenis Transaksi --</option>
                                    @foreach ($cashflowtypes as $cashflowtype)
                                    <option value="{{ $cashflowtype->id }}" {{ old('cashflowtype_id') == $cashflowtype->id ? 'selected' : '' }}>{{ $cashflowtype->name }}</option>
                                    @endforeach
                                </select>
                                @error('cashflowtype_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="name">Kategori<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"  required>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {{-- <div class="form-group col-md-12">
                                <label for="detail">Keterangan<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail"  required>
                                @error('detail')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> --}}
                        </div>
                        <!-- end: Input Data -->
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Simpan</button>
                            <a class="btn bg-danger" href="{{ route('category.index') }}">Batalkan</a>
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
