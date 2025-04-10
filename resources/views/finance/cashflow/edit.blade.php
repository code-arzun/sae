{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js"></script> --}}

<div id="editTransaksi{{ $cashflow->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editTransaksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white" id="editTransaksiLabel">Edit {{ $title }}</h3>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
            </div>
            <div class="modal-body bg-gray-100">
                <form action="{{ route('cashflow.update', $cashflow->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Tanggal -->
                            <div class="form-group col-md-3">
                                <label for="date">Tanggal</label>
                                {{-- <input id="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date', $cashflow->date) }}"> --}}
                                {{-- <input class="form-control @error('date') is-invalid @enderror" type="date" value="{{ old('date') }}" name="date" id="demo-date-only" required> --}}
                                <input class="form-control @error('date') is-invalid @enderror" type="date"
                                    value="{{ old('date', $cashflow->date ? $cashflow->date->format('Y-m-d') : '') }}"
                                    name="date" id="demo-date-only" required>
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
                                        <option value="{{ $department->id }}" {{ old('department_id', $cashflow->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
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
                                        @if (old('cashflowcategory_id', $cashflow->cashflowcategory->type === 'Pemasukan') == ($cashflowcategory->type === 'Pemasukan'))
                                            {{-- <option value="{{ $cashflowcategory->id }}" {{ old('cashflowcategory_id', $cashflow->cashflowcategory_id) == $cashflowcategory->id ? 'selected' : '' }}>{{ $cashflowcategory->type }} {{ $cashflowcategory->category }} {{ $cashflowcategory->detail }}</option> --}}
                                            <option value="{{ $cashflowcategory->id }}" {{ old('cashflowcategory_id', $cashflow->cashflowcategory_id) == $cashflowcategory->id ? 'selected' : '' }}>{{ $cashflowcategory->category }} {{ $cashflowcategory->detail }}</option>
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
                            <div class="form-group col-md-3">
                                <label for="nominal">Nominal<span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" value="{{ old('nominal', $cashflow->nominal) }}" required>
                                @error('nominal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        <!-- Keterangan -->
                            <div class="form-group col-md-12">
                                <label for="notes">Keterangan</label>
                                <input type="text" class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" value="{{ old('notes', $cashflow->notes) }}">
                                @error('notes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        <!-- Metode -->
                            <div class="form-group col-md-2">
                                <label for="method" class="mb-1">Metode Transaksi</label>
                                <div class="col-md d-flex justify-content-between" id="editTransaksi">
                                    <input type="radio" id="editTunai{{ $cashflow->id }}" name="method" value="Tunai" hidden {{ $cashflow->method === 'Tunai' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-warning tunai w-100 me-1 {{ $cashflow->method === 'Tunai' ? 'active' : '' }}" for="editTunai{{ $cashflow->id }}">Tunai</label>
                                    
                                    <input type="radio" id="editTransfer{{ $cashflow->id }}" name="method" value="Transfer" hidden {{ $cashflow->method === 'Transfer' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-success transfer w-100 {{ $cashflow->method === 'Transfer' ? 'active' : '' }}" for="editTransfer{{ $cashflow->id }}">Transfer</label>
                                    
                                </div>
                            </div>
                        <!-- Diterima oleh -->
                            <div class="form-group col-md" id="editPegawai" style="display: none;">
                                <label for="employee_id">Diterima oleh</label>
                                <select class="form-control bg-white text-center  @error('employee_id') is-invalid @enderror" name="employee_id" id="employee_id">
                                    <option value="" selected disabled>Pilih Penerima</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('employee_id', $cashflow->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('employee_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        <!-- Bank -->
                            <div class="form-group col-md-2" id="editBank" style="display: none;">
                                <label for="bank_id">Bank
                                    @if (old('cashflowcategory_id', $cashflow->cashflowcategory->type === 'Pemasukan') == ($cashflowcategory->type === 'Pemasukan'))
                                    Pengirim
                                    @else
                                    Penerima
                                    @endif
                                </label>
                                <select class="form-control bg-white text-center" name="bank_id" id="bank_id">
                                    <option value="" selected disabled>Pilih Bank</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}" {{ old('bank_id', $cashflow->bank_id) == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        <!-- Nomor Rekening -->
                            <div class="form-group col-md-3" id="editRekeningPartner" style="display: none;">
                                <label for="rekeningPartner">Rekening
                                    @if (old('cashflowcategory_id', $cashflow->cashflowcategory->type === 'Pemasukan') == ($cashflowcategory->type === 'Pemasukan'))
                                    Pengirim
                                    @else
                                    Penerima
                                    @endif
                                </label>
                                <input type="text" class="form-control text-center" id="rekeningPartner" name="rekeningPartner" value="{{ old('rekeningPartner', $cashflow->rekeningPartner) }}" placeholder="No. Rek. Pengirim">
                            </div>
                        <!-- Nama Pemilik Rekening -->
                            <div class="form-group col-md-2" id="editNamaPartner" style="display: none;">
                                <label for="namaPartner">Nama Pemilik Rek.</label>
                                <input type="text" class="form-control text-center" id="namaPartner" name="namaPartner" value="{{ old('namaPartner', $cashflow->namaPartner) }}" placeholder="Nama">
                            </div>
                        <!-- Rekening Perusahaan -->
                            <div class="form-group col-md-3" id="editRekeningPerusahaan" style="display: none;">
                                <label for="rekening_id">Rekening
                                    @if (old('cashflowcategory_id', $cashflow->cashflowcategory->type === 'Pemasukan') == ($cashflowcategory->type === 'Pemasukan'))
                                    Penerima
                                    @else
                                    Pengirim
                                    @endif
                                </label>
                                <select class="form-control bg-white text-center" name="rekening_id" id="rekening_id">
                                    <option value="" selected disabled>Pilih Rekening Penerima</option>
                                    @foreach ($rekeningPerusahaans as $rekening)
                                        <option value="{{ $rekening->id }}" {{ old('rekening_id', $cashflow->rekening_id) == $rekening->id ? 'selected' : '' }}>{{ $rekening->bank->name }} - {{ $rekening->no_rek }} | {{ $rekening->nama }}</option>
                                    @endforeach
                                </select>
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



{{-- <script>
    $('#date').datepicker({
        uiLibrary: 'bootstrap4',
        // format: 'dd-mm-yyyy'
        format: 'yyyy-mm-dd'
        // https://gijgo.com/datetimepicker/configuration/format
    });
</script> --}}
<script>
    $(document).ready(function () {
        $('.modal').each(function () {
            const modal = $(this);
            const methodName = 'method';

            const checkedMethod = modal.find(`input[name="${methodName}"]:checked`).val();
            toggleFields(modal, checkedMethod);

            modal.find(`input[name="${methodName}"]`).on('change', function () {
                toggleFields(modal, $(this).val());
            });
        });

        function toggleFields(modal, method) {
            const pegawaiFields = modal.find('#editPegawai input, #editPegawai select, #editPegawai textarea');
            const transferFields = modal.find('#editBank input, #editBank select, #editBank textarea, #editRekeningPartner input, #editRekeningPartner select, #editRekeningPartner textarea, #editNamaPartner input, #editNamaPartner select, #editNamaPartner textarea, #editRekeningPerusahaan input, #editRekeningPerusahaan select, #editRekeningPerusahaan textarea');

            if (method === 'Tunai') {
                modal.find('#editPegawai').show();
                modal.find('#editBank, #editRekeningPartner, #editNamaPartner, #editRekeningPerusahaan').hide();

                pegawaiFields.prop('disabled', false);
                transferFields.prop('disabled', true);
            } else if (method === 'Transfer') {
                modal.find('#editPegawai').hide();
                modal.find('#editBank, #editRekeningPartner, #editNamaPartner, #editRekeningPerusahaan').show();

                pegawaiFields.prop('disabled', true);
                transferFields.prop('disabled', false);
            }
        }
    });
</script>
