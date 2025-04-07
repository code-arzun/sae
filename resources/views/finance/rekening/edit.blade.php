<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js"></script>

<div id="editRekening{{ $rekening->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editRekeningLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white" id="editRekeningLabel">Tambah {{ $title }} Baru</h3>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
            </div>
            <div class="modal-body bg-gray-100">
                <form action="{{ route('rekening.update', $rekening->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="bank_id">Bank<span class="text-danger">*</span></label>
                            <select class="form-control" name="bank_id" required>
                                <option selected="" disabled>-- Pilih Bank --</option>
                                @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}" {{ old('bank_id', $rekening->bank_id) == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                @endforeach
                            </select>
                            @error('bank_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-5">
                            <label for="no_rek">No. Rekening<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_rek') is-invalid @enderror" id="no_rek" name="no_rek" value="{{ old('no_rek', $rekening->no_rek) }}" placeholder="Masukkan nomor rekening" required>
                            @error('no_rek')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="nama">Nama<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $rekening->nama) }}" placeholder="Masukkan nama pemilik rekening" required>
                            @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
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
