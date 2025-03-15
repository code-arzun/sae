@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('customers.index') }}" class="badge bg-primary"data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left"></i></a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit Customer</h4>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                        <!-- begin: Input Image -->
                        <div class="form-group row align-items-center">
                            <div class="col-md-12">
                                <div class="profile-img-edit">
                                    <div class="crm-profile-img-edit">
                                        <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="{{ $customer->photo ? asset('storage/customers/'.$customer->photo) : asset('assets/images/user/1.png') }}" alt="profile-pic">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group mb-4 col-lg-6">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" id="image" name="photo" accept="image/*" onchange="previewImage();">
                                    <label class="custom-file-label" for="photo">Choose file</label>
                                </div>
                                @error('photo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- end: Input Image -->
                        <!-- begin: Input Data -->
                        <div class=" row align-items-center">
                            <div class="form-group col-md">
                                <label for="NamaLembaga">Nama Lembaga <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('NamaLembaga') is-invalid @enderror" id="NamaLembaga" name="NamaLembaga" value="{{ old('NamaLembaga', $customer->NamaLembaga) }}" placeholder="Nama Lembaga" required>
                                @error('NamaLembaga')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="TelpLembaga">Telp. Lembaga</label>
                                <input type="text" class="form-control @error('TelpLembaga') is-invalid @enderror" id="TelpLembaga" name="TelpLembaga" value="{{ old('TelpLembaga', $customer->TelpLembaga) }}" placeholder="Telp. Lembaga" >
                                @error('TelpLembaga')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="EmailLembaga">E-Mail Lembaga</label>
                                <input type="text" class="form-control @error('EmailLembaga') is-invalid @enderror" id="EmailLembaga" name="EmailLembaga" value="{{ old('EmailLembaga', $customer->EmailLembaga) }}" placeholder="E-mail Lembaga" >
                                @error('EmailLembaga')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                        </div>
                           
                        {{-- BARIS 2 --}}
                        <div class=" row align-items-center">
                            <div class="form-group col-md">
                                <label for="AlamatLembaga">Alamat Lembaga</label>
                                <input type="text" class="form-control @error('AlamatLembaga') is-invalid @enderror" id="AlamatLembaga" name="AlamatLembaga" value="{{ old('AlamatLembaga', $customer->AlamatLembaga)  }}" placeholder="Alamat Lembaga">
                                @error('AlamatLembaga')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        {{-- BARIS 3 --}}
                        <div class=" row align-items-center">
                            <div class="form-group col-md-2">
                                <label for="Potensi">Potensi</label>
                                <select class="form-control @error('Potensi') is-invalid @enderror" name="Potensi">
                                    <option value="" disabled>-- Potensi --</option>
                                    <option value="Tinggi" @if(old('Potensi', $customer->Potensi) == 'Tinggi')selected="selected"@endif>Tinggi</option>
                                    <option value="Sedang" @if(old('Potensi', $customer->Potensi) == 'Sedang')selected="selected"@endif>Sedang</option>
                                    <option value="Remdah" @if(old('Potensi', $customer->Potensi) == 'Remdah')selected="selected"@endif>Remdah</option>
                                </select>
                                @error('Potensi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md">
                                <label for="CatatanLembaga">Catatan Lembaga</label>
                                <input type="text" class="form-control @error('CatatanLembaga') is-invalid @enderror" id="CatatanLembaga" name="CatatanLembaga" value="{{ old('CatatanLembaga', $customer->CatatanLembaga) }}" placeholder="Catatan Lembaga">
                                @error('CatatanLembaga')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class=" row align-items-center"> 
                            <div class="form-group col-md mt-3 mb-2"> <h5> Data Customer</h5>
                            </div>
                        </div>

                        {{-- BARIS 1 --}}
                        <div class=" row align-items-center">
                            <div class="form-group col-md">
                                <label for="NamaCustomer">Nama Customer <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('NamaCustomer') is-invalid @enderror" id="NamaCustomer" name="NamaCustomer" value="{{ old('NamaCustomer', $customer->NamaCustomer) }}" placeholder="Nama Customer" required>
                                @error('NamaCustomer')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="Jabatan">Jabatan</label>
                                <select class="form-control @error('Jabatan') is-invalid @enderror" name="Jabatan">
                                    <option value="" disabled>-- Jabatan --</option>
                                    <option value="Kepala Sekolah" @if(old('Jabatan', $customer->Jabatan) == 'Kepala Sekolah')selected="selected"@endif>Kepala Sekolah</option>
                                    <option value="Bendahara BOS" @if(old('Jabatan', $customer->Jabatan) == 'Bendahara BOS')selected="selected"@endif>Bendahara BOS</option>
                                    <option value="Operator BOS" @if(old('Jabatan', $customer->Jabatan) == 'Operator BOS')selected="selected"@endif>Operator BOS</option>
                                    <option value="Guru" @if(old('Jabatan', $customer->Jabatan) == 'Guru')selected="selected"@endif>Guru</option>
                                </select>
                                @error('Jabatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-2">
                                <label for="TelpCustomer">Telp. Customer</label>
                                <input type="text" class="form-control @error('TelpCustomer') is-invalid @enderror" id="TelpCustomer" name="TelpCustomer" value="{{ old('TelpCustomer', $customer->TelpCustomer) }}" placeholder="Telp. Customer">
                                @error('TelpCustomer')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="EmailCustomer">E-Mail Customer</label>
                                <input type="text" class="form-control @error('EmailCustomer') is-invalid @enderror" id="EmailCustomer" name="EmailCustomer" value="{{ old('EmailCustomer', $customer->EmailCustomer) }}" placeholder="E-Mail Customer">
                                @error('EmailCustomer')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                        </div>
                          
                        {{-- BARIS 2 --}}
                        <div class=" row align-items-center">
                            <div class="form-group col-md">
                                <label for="AlamatCustomer">Alamat Customer</label>
                                <input type="text" class="form-control @error('AlamatCustomer') is-invalid @enderror" id="AlamatCustomer" name="AlamatCustomer" value="{{ old('AlamatCustomer', $customer->AlamatCustomer) }}" placeholder="Alamat Customer">
                                @error('AlamatCustomer')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        {{-- BARIS 3 --}}
                        <div class=" row align-items-center">
                            <div class="form-group col-md">
                                <label for="CatatanCustomer">Catatan Customer</label>
                                <input type="text" class="form-control @error('CatatanCustomer') is-invalid @enderror" id="CatatanCustomer" name="CatatanCustomer" value="{{ old('CatatanCustomer', $customer->CatatanCustomer) }}" placeholder="Catatan Customer">
                                @error('CatatanCustomer')
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
                                    <input type="file" class="custom-file-input @error('FotoCustomer') is-invalid @enderror" id="image" name="FotoCustomer" accept="image/*" onchange="previewImage();">
                                    <label class="custom-file-label" for="FotoCustomer">Pilih Foto Customer</label>
                                </div>
                                @error('FotoCustomer')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- SALES --}}
                        <div class=" row align-items-center">
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
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Perbarui</button>
                            <a class="btn bg-danger" href="{{ route('customers.index') }}">Batalkan</a>
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
