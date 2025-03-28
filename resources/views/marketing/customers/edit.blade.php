<div id="editCustomer{{ $customer->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white" id="editCustomerLabel">Edit {{ $title }}</h3>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
            </div>
            <div class="modal-body bg-gray-100">
                <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
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
                                        id="NamaLembaga" name="NamaLembaga" value="{{ old('NamaLembaga', $customer->NamaLembaga) }}" placeholder="Nama Lembaga (Wajib diisi!)" required>
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
                                            <option value="Prioritas" @if(old('Potensi', $customer->Potensi) == 'Prioritas')selected="selected"@endif>Prioritas</option>
                                            <option value="Tinggi" @if(old('Potensi', $customer->Potensi) == 'Tinggi')selected="selected"@endif>Tinggi</option>
                                            <option value="Sedang" @if(old('Potensi', $customer->Potensi) == 'Sedang')selected="selected"@endif>Sedang</option>
                                            <option value="Rendah" @if(old('Potensi', $customer->Potensi) == 'Rendah')selected="selected"@endif>Rendah</option>
                                        </select>
                                        @error('Potensi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="AlamatLembaga">Alamat Lembaga</label>
                                        <textarea rowspan="3" class="form-control @error('AlamatLembaga') is-invalid @enderror" id="AlamatLembaga" name="AlamatLembaga" value="{{ old('AlamatLembaga', $customer->AlamatLembaga) }}" placeholder="Alamat Lembaga"></textarea>
                                        @error('AlamatLembaga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="TelpLembaga">Telp. Lembaga</label>
                                        <input type="text" class="form-control @error('TelpLembaga') is-invalid @enderror" id="TelpLembaga" name="TelpLembaga" value="{{ old('TelpLembaga', $customer->TelpLembaga) }}" placeholder="Telp. Lembaga">
                                        @error('TelpLembaga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="EmailLembaga">E-Mail Lembaga</label>
                                        <input type="text" class="form-control @error('EmailLembaga') is-invalid @enderror" id="EmailLembaga" name="EmailLembaga" value="{{ old('EmailLembaga', $customer->EmailLembaga) }}" placeholder="E-Mail Lembaga">
                                        @error('EmailLembaga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="CatatanLembaga">Catatan Lembaga</label>
                                        <textarea rowspan="3" class="form-control @error('CatatanLembaga') is-invalid @enderror" id="CatatanLembaga" name="CatatanLembaga" value="{{ old('CatatanLembaga', $customer->CatatanLembaga) }}" placeholder="Catatan Lembaga"></textarea>
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
                                        id="NamaCustomer" name="NamaCustomer" value="{{ old('NamaCustomer', $customer->NamaCustomer) }}" placeholder="Nama Customer (Wajib diisi!)" required>
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
                                    <div class="form-group col-md-12">
                                        <label for="AlamatCustomer">Alamat Customer</label>
                                        <textarea rowspan="3" class="form-control @error('AlamatCustomer') is-invalid @enderror" id="AlamatCustomer" name="AlamatCustomer" value="{{ old('AlamatCustomer', $customer->AlamatCustomer) }}" placeholder="Alamat Customer"></textarea>
                                        @error('AlamatCustomer')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="TelpCustomer">Telp. Customer</label>
                                        <input type="text" class="form-control @error('TelpCustomer') is-invalid @enderror" id="TelpCustomer" name="TelpCustomer" value="{{ old('TelpCustomer', $customer->TelpCustomer) }}" placeholder="Telp. Customer">
                                        @error('TelpCustomer')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="EmailCustomer">E-Mail Customer</label>
                                        <input type="text" class="form-control @error('EmailCustomer') is-invalid @enderror" id="EmailCustomer" name="EmailCustomer" value="{{ old('EmailCustomer', $customer->EmailCustomer) }}" placeholder="E-Mail Customer">
                                        @error('EmailCustomer')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group col-md-12">
                                        <label for="CatatanCustomer">Catatan Customer</label>
                                        <textarea rowspan="3" class="form-control @error('CatatanCustomer') is-invalid @enderror" id="CatatanCustomer" name="CatatanCustomer" value="{{ old('CatatanCustomer', $customer->CatatanCustomer) }}" placeholder="Catatan Customer (opsional)"></textarea>
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
                                                {{-- <input type="file" class="custom-file-input @error('FotoCustomer') is-invalid @enderror" id="image" name="FotoCustomer" accept="image/*" onchange="previewImage();"> --}}
                                                {{-- <label class="custom-file-label" for="FotoCustomer">Pilih Foto Customer</label> --}}
                                                <input type="file" class="custom-file-input @error('FotoCustomer') is-invalid @enderror" id="image" name="FotoCustomer" accept="image/*" onchange="previewImage();">
                                                <!-- Tambahkan elemen untuk preview gambar yang sudah ada -->
                                                <div class="mt-2">
                                                    <img id="existingImagePreview" src="{{ asset('storage/path/to/your/images/' . $customer->FotoCustomer) }}" class="img-thumbnail" width="150" style="display: {{ $customer->FotoCustomer ? 'block' : 'none' }};">
                                                    <small class="form-text text-muted">
                                                        Gambar saat ini
                                                    </small>
                                                </div>
                                                <!-- Preview untuk gambar baru yang dipilih -->
                                                <div class="mt-2">
                                                    <img id="imagePreview" class="img-thumbnail" width="150" style="display: none;">
                                                    <small class="form-text text-muted">
                                                        Preview gambar baru
                                                    </small>
                                                </div>
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
                                        <option value="{{ $employee->id }}" {{ old('employee_id', $customer->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
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
                    <!-- <div class="mt-2"> -->
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
  </div>

  <script>
    function previewImage() {
    const fileInput = document.getElementById('image');
    const existingPreview = document.getElementById('existingImagePreview');
    const newPreview = document.getElementById('imagePreview');
    
    // Jika memilih file baru
    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            newPreview.src = e.target.result;
            newPreview.style.display = 'block';
            existingPreview.style.display = 'none'; // Sembunyikan gambar lama
        }
        
        reader.readAsDataURL(fileInput.files[0]);
    } else {
        newPreview.style.display = 'none';
        existingPreview.style.display = 'block'; // Tampilkan kembali gambar lama
    }
}

// Saat modal ditutup, reset preview
$('#yourEditModal').on('hidden.bs.modal', function () {
    document.getElementById('image').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('existingImagePreview').style.display = 'block';
});
  </script>