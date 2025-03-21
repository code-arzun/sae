<div id="tambahCustomer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tambahCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white" id="tambahCustomerLabel">Tambah {{ $title }} Baru</h3>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
            </div>
            <div class="modal-body bg-gray-100">
                <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Data Lembaga -->
                        <div class="col-lg-6">
                            <h4>Data Lembaga</h4>
                            <div class="card">
                                <div class="card-body row">
                                    <div class="form-group col-md">
                                        <label for="NamaLembaga">Nama Lembaga <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('NamaLembaga') is-invalid @enderror" 
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Wajib diisi!"
                                        id="NamaLembaga" name="NamaLembaga" value="{{ old('NamaLembaga') }}" placeholder="Nama Lembaga (Wajib diisi!)" required>
                                        @error('NamaLembaga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Potensi">Potensi</label>
                                        <select class="form-control @error('Potensi') is-invalid @enderror" name="Potensi">
                                            <option value="" selected disabled>-- Potensi --</option>
                                            <option value="Prioritas">Prioritas</option>
                                            <option value="Tinggi">Tinggi</option>
                                            <option value="Sedang">Sedang</option>
                                            <option value="Rendah">Rendah</option>
                                        </select>
                                        @error('Potensi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="AlamatLembaga">Alamat Lembaga</label>
                                        <textarea rowspan="3" class="form-control @error('AlamatLembaga') is-invalid @enderror" id="AlamatLembaga" name="AlamatLembaga" value="{{ old('AlamatLembaga') }}" placeholder="Alamat Lembaga"></textarea>
                                        @error('AlamatLembaga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="TelpLembaga">Telp. Lembaga</label>
                                        <input type="text" class="form-control @error('TelpLembaga') is-invalid @enderror" id="TelpLembaga" name="TelpLembaga" value="{{ old('TelpLembaga') }}" placeholder="Telp. Lembaga">
                                        @error('TelpLembaga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="EmailLembaga">E-Mail Lembaga</label>
                                        <input type="text" class="form-control @error('EmailLembaga') is-invalid @enderror" id="EmailLembaga" name="EmailLembaga" value="{{ old('EmailLembaga') }}" placeholder="E-Mail Lembaga">
                                        @error('EmailLembaga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="CatatanLembaga">Catatan Lembaga</label>
                                        <textarea rowspan="3" class="form-control @error('CatatanLembaga') is-invalid @enderror" id="CatatanLembaga" name="CatatanLembaga" value="{{ old('CatatanLembaga') }}" placeholder="Catatan Lembaga"></textarea>
                                        @error('CatatanLembaga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Data Customer -->
                        <div class="col-lg-6">
                            <h4>Data Customer</h4>
                            <div class="card">
                                <div class="card-body row">
                                    <div class="form-group col-md">
                                        <label for="NamaCustomer">Nama Customer <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('NamaCustomer') is-invalid @enderror"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Wajib diisi!"
                                        id="NamaCustomer" name="NamaCustomer" value="{{ old('NamaCustomer') }}" placeholder="Nama Customer (Wajib diisi!)" required>
                                        @error('NamaCustomer')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Jabatan">Jabatan</label>
                                        <select class="form-control @error('Jabatan') is-invalid @enderror" name="Jabatan">
                                            <option value="" selected disabled>-- Jabatan --</option>
                                            <option value="Kepala Sekolah">Kepala Sekolah</option>
                                            <option value="Bendahara BOS">Bendahara BOS</option>
                                            <option value="Operator BOS">Operator BOS</option>
                                            <option value="Guru">Guru</option>
                                        </select>
                                        @error('Jabatan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="AlamatCustomer">Alamat Customer</label>
                                        <textarea rowspan="3" class="form-control @error('AlamatCustomer') is-invalid @enderror" id="AlamatCustomer" name="AlamatCustomer" value="{{ old('AlamatCustomer') }}" placeholder="Alamat Customer"></textarea>
                                        @error('AlamatCustomer')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="TelpCustomer">Telp. Customer</label>
                                        <input type="text" class="form-control @error('TelpCustomer') is-invalid @enderror" id="TelpCustomer" name="TelpCustomer" value="{{ old('TelpCustomer') }}" placeholder="Telp. Customer">
                                        @error('TelpCustomer')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="EmailCustomer">E-Mail Customer</label>
                                        <input type="text" class="form-control @error('EmailCustomer') is-invalid @enderror" id="EmailCustomer" name="EmailCustomer" value="{{ old('EmailCustomer') }}" placeholder="E-Mail Customer">
                                        @error('EmailCustomer')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group col-md-12">
                                        <label for="CatatanCustomer">Catatan Customer</label>
                                        <textarea rowspan="3" class="form-control @error('CatatanCustomer') is-invalid @enderror" id="CatatanCustomer" name="CatatanCustomer" value="{{ old('CatatanCustomer') }}" placeholder="Catatan Customer (opsional)"></textarea>
                                        @error('CatatanCustomer')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <!-- Input Image -->
                                        <div class="form-group row align-items-center">
                                            <div class="col-md-12">
                                                <div class="profile-img-edit">
                                                    <div class="crm-profile-img-edit">
                                                        <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="{{ asset('assets/images/user/1.jpg') }}" alt="profile-pic">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group col-lg-6">
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
                            </div>
                        </div>
                        <!-- Nama Sales -->
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                        <div class="col-lg">
                            <h5>Sales</h5>
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
                        @endif
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