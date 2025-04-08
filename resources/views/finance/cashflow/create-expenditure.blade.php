<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js"></script>


<div id="createExpenditure" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createExpenditureLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h3 class="modal-title text-white" id="createExpenditureLabel">Tambah Pengeluaran Baru</h3>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
            </div>
            <div class="modal-body bg-gray-100">
                <form action="{{ route('cashflow.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Tanggal -->
                            <div class="form-group col-md-2">
                                <label for="date">Tanggal</label>
                                <input class="form-control @error('date') is-invalid @enderror" type="date" value="{{ old('date') }}" name="date" id="demo-date-only">
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
                            <div class="form-group col-md-5">
                                <label for="cashflowcategory_id">Kategori <span class="text-danger">*</span></label>
                                <select class="form-control" name="cashflowcategory_id" required>
                                    <option selected="" disabled>-- Pilih Kategori --</option>
                                    @foreach ($cashflowcategories as $cashflowcategory)
                                    @if ($cashflowcategory->type === 'Pengeluaran')
                                        <option value="{{ $cashflowcategory->id }}" {{ old('cashflowcategory_id') == $cashflowcategory->id ? 'selected' : '' }}>{{ $cashflowcategory->category }} {{ $cashflowcategory->detail }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('cashflowcategory_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        <!-- Nominal -->
                            <div class="form-group col-md-2">
                                <label for="nominal">Nominal<span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" value="{{ old('nominal') }}" placeholder="Masukkan nominal pengeluaran!" required>
                                @error('nominal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        <!-- Keterangan -->
                            <div class="form-group col-md-12">
                                <label for="notes">Keterangan</label>
                                <input type="text" class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" value="{{ old('notes') }}" placeholder="Masukkan keterangan pengeluaran!">
                                @error('notes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        <!-- Metode -->
                        <div class="form-group col-md-2">
                            <label for="method" class="mb-1">Metode Transaksi</label>
                            <div class="col-md d-flex justify-content-between" id="createExpenditure">
                                <input type="radio" id="expenditureTunai" name="method" value="Tunai" hidden>
                                <label class="btn btn-outline-warning tunai w-100 me-1" for="expenditureTunai"> Tunai </label>
                                <input type="radio" id="expenditureTransfer" name="method" value="Transfer" hidden>
                                <label class="btn btn-outline-success transfer w-100" for="expenditureTransfer"> Transfer </label>
                            </div>
                        </div>
                        <!-- Dibayarkan oleh -->
                            <div class="form-group col-md" id="pegawai" style="display: none;">
                                <label for="employee_id">Dibayarkan oleh</label>
                                <select class="form-control bg-white text-center  @error('employee_id') is-invalid @enderror" name="employee_id" id="employee_id">
                                    <option value="" selected disabled>Pilih Pembayar</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('employee_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        <!-- Rekening Perusahaan -->
                        <div class="form-group col-md-3" id="rekeningPerusahaan" style="display: none;">
                            <label for="rekening_id">Rekening Pengirim</label>
                            <select class="form-control bg-white text-center" name="rekening_id" id="rekening_id">
                                <option value="" selected disabled>Pilih Rekening Pengirim</option>
                                @foreach ($rekeningPerusahaans as $rekening)
                                    <option value="{{ $rekening->id }}">{{ $rekening->bank->name }} - {{ $rekening->no_rek }} | {{ $rekening->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Bank -->
                            <div class="form-group col-md-2" id="bank" style="display: none;">
                                <label for="bank_id">Bank Penerima</label>
                                <select class="form-control bg-white text-center" name="bank_id" id="bank_id">
                                    <option value="" selected disabled>Pilih Bank</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                            </div>
            
                        <!-- Nomor Rekening -->
                            <div class="form-group col-md-3" id="rekeningPartner" style="display: none;">
                                <label for="rekeningPartner">Rekening Penerima</label>
                                <input type="text" class="form-control text-center" id="rekeningPartner" name="rekeningPartner" value="{{ old('rekeningPartner') }}" placeholder="No. Rek. Penerima">
                            </div>
                        
                        <!-- Nama Pemilik Rekening -->
                        <div class="form-group col-md-2" id="namaPartner" style="display: none;">
                            <label for="namaPartner">Nama Pemilik Rek.</label>
                            <input type="text" class="form-control text-center" id="namaPartner" name="namaPartner" value="{{ old('namaPartner') }}" placeholder="Nama">
                        </div>
            

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
