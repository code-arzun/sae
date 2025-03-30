@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Buat Keterangan</h4>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('detail.store') }}" method="POST">
                    @csrf
                        <!-- begin: Input Data -->
                        <div class=" row align-items-center">
                            <div class="form-group col-md-12">
                                <label for="cashflowcategory_id">Jenis Kategori<span class="text-danger">*</span></label>
                                <select class="form-control" name="cashflowcategory_id" required>
                                    <option selected="" disabled>-- Pilih Jenis Kategori --</option>
                                    @foreach ($cashflowcategories as $cashflowcategory)
                                    <option value="{{ $cashflowcategory->id }}" {{ old('cashflowcategory_id') == $cashflowcategory->id ? 'selected' : '' }}>{{ $cashflowcategory->cashflowtype->name }} | {{ $cashflowcategory->name }}</option>
                                    @endforeach
                                </select>
                                @error('cashflowcategory_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="name">Keterangan<span class="text-danger">*</span></label>
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
                            <a class="btn bg-danger" href="{{ route('detail.index') }}">Batalkan</a>
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
