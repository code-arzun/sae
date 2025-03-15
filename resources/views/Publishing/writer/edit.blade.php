@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('writer.index') }}" class="badge bg-primary"data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left"></i></a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit Writer</h4>
                    </div>
                </div> --}}

                <div class="card-body">
                    <form action="{{ route('writer.update', $writer->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                        <!-- begin: Input Data -->
                        <div class="row align-items-center">
                            <!-- Nama Penulis -->
                            <div class="form-group col-md-6">
                                <label for="NamaPenulis">Nama Penulis <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('NamaPenulis') is-invalid @enderror" id="NamaPenulis" name="NamaPenulis" value="{{ old('NamaPenulis', $writer->NamaPenulis) }}" placeholder="Nama Penulis" required>
                                @error('NamaPenulis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Profesi -->
                            <div class="form-group col-md-3">
                                <label for="writerjob_id">Profesi</label>
                                <select class="form-control" name="writerjob_id" required>
                                    <option selected disabled>-- Pilih Profesi --</option>
                                    @foreach ($writerjobs as $writerjob)
                                        <option value="{{ $writerjob->id }}" {{ old('writerjob_id', $writer->writerjob_id) == $writerjob->id ? 'selected' : '' }}>{{ $writerjob->nama }}</option>
                                    @endforeach
                                </select>
                                @error('writerjob_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Kategori -->
                            <div class="form-group col-md-3">
                                <label for="writercategory_id">Kategori</label>
                                <select class="form-control" name="writercategory_id" required>
                                    <option selected disabled>-- Pilih Kategori --</option>
                                    @foreach ($writercategories as $writercategory)
                                        <option value="{{ $writercategory->id }}" {{ old('writercategory_id', $writer->writercategory_id) == $writercategory->id ? 'selected' : '' }}>{{ $writercategory->nama }}</option>
                                    @endforeach
                                </select>
                                @error('writercategory_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- NIK -->
                            <div class="form-group col-md-3">
                                <label for="NIK">NIK</label>
                                <input type="text" class="form-control @error('NIK') is-invalid @enderror" id="NIK" name="NIK" value="{{ old('NIK', $writer->NIK) }}" placeholder="NIK" >
                                @error('NIK')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- NPWP -->
                            <div class="form-group col-md-3">
                                <label for="NPWP">NPWP</label>
                                <input type="text" class="form-control @error('NPWP') is-invalid @enderror" id="NPWP" name="NPWP" value="{{ old('NPWP', $writer->NPWP) }}" placeholder="NPWP" >
                                @error('NPWP')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Telp -->
                            <div class="form-group col-md-3">
                                <label for="TelpPenulis">Telp. Penulis</label>
                                <input type="text" class="form-control @error('TelpPenulis') is-invalid @enderror" id="TelpPenulis" name="TelpPenulis" value="{{ old('TelpPenulis', $writer->TelpPenulis) }}" placeholder="Telp. Penulis" >
                                @error('TelpPenulis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Email -->
                            <div class="form-group col-md-3">
                                <label for="EmailPenulis">E-Mail Penulis</label>
                                <input type="text" class="form-control @error('EmailPenulis') is-invalid @enderror" id="EmailPenulis" name="EmailPenulis" value="{{ old('EmailPenulis', $writer->EmailPenulis) }}" placeholder="E-mail Penulis" >
                                @error('EmailPenulis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Alamat  -->
                            <div class="form-group col-md-12">
                                <label for="AlamatPenulis">Alamat Penulis</label>
                                {{-- <input type="text" class="form-control @error('AlamatPenulis') is-invalid @enderror" id="AlamatPenulis" name="AlamatPenulis" value="{{ old('AlamatPenulis', $writer->AlamatPenulis)  }}" placeholder="Alamat Penulis"> --}}
                                <textarea type="text" class="form-control @error('AlamatPenulis') is-invalid @enderror" id="AlamatPenulis" name="AlamatPenulis" rows="3" placeholder="Alamat Penulis">{{ old('AlamatPenulis', $writer->AlamatPenulis)  }}</textarea>
                                @error('AlamatPenulis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Catatan -->
                            <div class="form-group col-md-12">
                                <label for="CatatanPenulis">Catatan Penulis</label>
                                {{-- <input type="text" class="form-control @error('CatatanPenulis') is-invalid @enderror" id="CatatanPenulis" name="CatatanPenulis" value="{{ old('CatatanPenulis', $writer->CatatanPenulis) }}" placeholder="Catatan Penulis"> --}}
                                <textarea type="text" class="form-control @error('CatatanPenulis') is-invalid @enderror" id="CatatanPenulis" name="CatatanPenulis" rows="3" placeholder="*Catatan Penulis">{{ old('CatatanPenulis', $writer->CatatanPenulis) }}</textarea>
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
                                    <input type="file" class="custom-file-input @error('FotoPenulis') is-invalid @enderror" id="image" name="FotoPenulis" accept="image/*" onchange="previewImage();">
                                    <label class="custom-file-label" for="FotoPenulis">Pilih Foto Writer</label>
                                </div>
                                @error('FotoPenulis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- diinput oleh -->
                        {{-- <div class=" row align-items-center">
                            <div class="form-group col-md-6">
                                <label for="employee_id">Sales <span class="text-danger">*</span></label>
                                <select class="form-control" name="employee_id" required>
                                    <option disabled>-- Pilih Sales --</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('employee_id', $employee->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Perbarui</button>
                            <a class="btn bg-danger" href="{{ route('writer.index') }}">Batalkan</a>
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
