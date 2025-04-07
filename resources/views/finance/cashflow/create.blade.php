<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js"></script>

<div id="tambahTransaksi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tambahTransaksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white" id="tambahTransaksiLabel">Tambah {{ $title }} Baru</h3>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
            </div>
            <div class="modal-body bg-gray-100">
                <form action="{{ route('cashflow.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Tanggal -->
                        <div class="form-group col-md-3">
                            <label for="date">Tanggal</label>
                            <input id="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" />
                            @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Divisi -->
                        <div class="form-group col-md-3">
                            <label for="department_id">Divisi <span class="text-danger">*</span></label>
                            <select class="form-control" name="department_id" required>
                                <option selected="" disabled>-- Pilih Divisi --</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Kategori -->
                        <div class="form-group col-md-3">
                            <label for="cashflowcategory_id">Kategori <span class="text-danger">*</span></label>
                            <select class="form-control" name="cashflowcategory_id" required>
                                <option selected="" disabled>-- Pilih Kategori --</option>
                                @foreach ($cashflowcategories as $cashflowcategory)
                                        <option value="{{ $cashflowcategory->id }}" {{ old('cashflowcategory_id') == $cashflowcategory->id ? 'selected' : '' }}>{{ $cashflowcategory->type }} {{ $cashflowcategory->category }} {{ $cashflowcategory->detail }}</option>
                                    {{-- @endif --}}
                                @endforeach
                            </select>
                            @error('cashflowcategory_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Nominal -->
                        <div class="form-group col-md-3">
                            <label for="nominal">Nominal<span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" value="{{ old('nominal') }}" required>
                            @error('nominal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Keterangan -->
                        <div class="form-group col-md">
                            <label for="notes">Keterangan</label>
                            <input type="text" class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" value="{{ old('notes') }}">
                            @error('notes')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Metode -->
                        
                        <!-- Bukti Transaksi -->
                        <div class="input-group mb-4 col-lg-6">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('receipt') is-invalid @enderror" id="image" name="receipt" accept="image/*" onchange="previewImage();">
                                <label class="custom-file-label" for="receipt">Upload bukti transaksi</label>
                            </div>
                            @error('receipt')
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



<script>
    $('#date').datepicker({
        uiLibrary: 'bootstrap4',
        // format: 'dd-mm-yyyy'
        format: 'yyyy-mm-dd'
        // https://gijgo.com/datetimepicker/configuration/format
    });
</script>