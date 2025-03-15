@extends('layout.main')

@section('container')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="col d-flex flex-wrap align-items-center justify-content-between mb-3">
                <div class="row">
                    <a href="{{ url()->previous() }}" class="badge bg-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left mb-1 mt-1"></i></a>
                    <a href="{{ route('writer.create') }}" class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div class="row d-flex flex-wrap align-items-center justify-content-between">
                    <div class="mr-3">
                        <h5>Tambah Penulis Baru</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                <form action="{{ route('writer.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="row align-items-center">
                        <!-- Nama -->
                        <div class="form-group col-md-6">
                            <label for="NamaPenulis">Nama Penulis</label>
                            <input type="text" class="form-control @error('NamaPenulis') is-invalid @enderror" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Wajib diisi!"
                                id="NamaPenulis" name="NamaPenulis" value="{{ old('NamaPenulis') }}" placeholder="Nama Penulis" {{-- placeholder="contoh: Dr. Soepomo, S.Pd., M.Sc." --}} required>
                            @error('NamaPenulis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Pekerjaan Penulis -->
                        <div class="form-group col-md-3">    
                            <label for="writerjob_id">
                                <a href="{{ route('writerjob.index') }}"
                                    data-bs-toggle="modal" data-target="#writerJobModal">Profesi Penulis
                                </a>
                            </label>
                            <div class="input-group">
                                <select class="form-control" name="writerjob_id" required>
                                    <option selected disabled>-- Profesi --</option>
                                    @foreach ($writerjobs as $writerjob)
                                        <option value="{{ $writerjob->id }}" {{ old('writerjob_id', $writerjob->writerjob_id) == $writerjob->id ? 'selected' : '' }}>{{ $writerjob->nama }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    {{-- <a class="input-group-text bg-primary" href="{{ route('writerjob.index') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Profesi Penulis"><i class="fa fa-plus"></i></a> --}}
                                    <button type="button" class="input-group-text bg-primary text-white"
                                        data-bs-toggle="modal" data-target="#inputWriterJobModal">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            @error('writerjob_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                            
                        </div>
                        <!-- Kategori Penulis -->
                        <div class="form-group col-md-3">
                            <label for="writercategory_id"><a href="{{ route('writercategory.index') }}">Kategori Penulis</a></label>
                            <div class="input-group">
                                <select class="form-control" name="writercategory_id" required>
                                    <option selected disabled>-- Kategori --</option>
                                    @foreach ($writercategories as $writercategory)
                                        <option value="{{ $writercategory->id }}" {{ old('writercategory_id', $writercategory->writercategory_id) == $writercategory->id ? 'selected' : '' }}>{{ $writercategory->nama }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    {{-- <a class="input-group-text bg-primary" href="{{ route('writercategory.index') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Profesi Penulis"><i class="fa fa-plus"></i></a> --}}
                                    <button type="button" class="input-group-text bg-primary text-white" data-bs-toggle="modal" data-target="#writerCategoryModal">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            @error('writercategory_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- NIK -->
                        <div class="form-group col-md-3">
                            <label for="NIK">NIK KTP</label>
                            <input type="text" class="form-control @error('NIK') is-invalid @enderror" id="NIK" name="NIK" value="{{ old('NIK') }}" placeholder="NIK KTP">
                            @error('NIK')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- NPWP -->
                        <div class="form-group col-md-3">
                            <label for="NPWP">NPWP</label>
                            <input type="text" class="form-control @error('NPWP') is-invalid @enderror" id="NPWP" name="NPWP" value="{{ old('NPWP') }}" placeholder="NPWP">
                            @error('NPWP')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Telp -->
                        <div class="form-group col-md-3">
                            <label for="TelpPenulis">Telp. Penulis</label>
                            <input type="text" class="form-control @error('TelpPenulis') is-invalid @enderror" id="TelpPenulis" name="TelpPenulis" value="{{ old('TelpPenulis') }}" placeholder="Telp.">
                            @error('TelpPenulis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Email -->
                        <div class="form-group col-md-3">
                            <label for="EmailPenulis">E-mail</label>
                            <input type="text" class="form-control @error('EmailPenulis') is-invalid @enderror" id="EmailPenulis" name="EmailPenulis" value="{{ old('EmailPenulis') }}" placeholder="E-Mail">
                            @error('EmailPenulis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Alamat -->
                        <div class="form-group col-md-12">
                            <label for="AlamatPenulis">Alamat</label>
                            {{-- <input type="text" class="form-control @error('AlamatPenulis') is-invalid @enderror" id="AlamatPenulis" name="AlamatPenulis" value="{{ old('AlamatPenulis') }}" placeholder="Alamat Penulis"> --}}
                            <textarea type="text" class="form-control @error('AlamatPenulis') is-invalid @enderror" id="AlamatPenulis" name="AlamatPenulis" rows="3" placeholder="Alamat Penulis"></textarea>
                            @error('AlamatPenulis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Catatan -->
                        <div class="form-group col-md-12">
                            <label for="CatatanPenulis">Catatan <span>(Opsional)</span></label>
                            {{-- <input type="text" class="form-control @error('CatatanPenulis') is-invalid @enderror" id="CatatanPenulis" name="CatatanPenulis" value="{{ old('CatatanPenulis') }}" placeholder="*Catatan Penulis"> --}}
                            <textarea type="text" class="form-control @error('CatatanPenulis') is-invalid @enderror" id="CatatanPenulis" name="CatatanPenulis" rows="3" placeholder="*Catatan Penulis"></textarea>
                            @error('CatatanPenulis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- begin: Input Image -->
                    <div class="form-group row align-items-center">
                        <div class="col-md-12">
                            <div class="profile-img-edit">
                                <div class="crm-profile-img-edit">
                                    <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="{{ asset('assets/images/user/1.png') }}" alt="profile-pic">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-group mb-4 col-lg-6">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('Fotowriter') is-invalid @enderror" id="image" name="Fotowriter" accept="image/*" onchange="previewImage();">
                                <label class="custom-file-label" for="Fotowriter">Pilih Foto</label>
                            </div>
                            @error('Fotowriter')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    {{-- <input type="text" class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" value="{{ auth()->user()->employee_id }}" hidden> --}}
                    <!-- <button type="button" class="btn btn-primary me-2 confirm-button">Simpan</button> -->
                    <a class="btn bg-danger me-2" href="{{ route('writer.create') }}">Batalkan</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>

@include('components.preview-img-form')
@include('Publishing.writer.job.create')
@include('Publishing.writer.job.index')
@include('Publishing.writer.category.create')
@endsection
