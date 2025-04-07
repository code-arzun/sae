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
                            <div class="form-group col-md-2">
                                <label for="nominal">Nominal<span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" value="{{ old('nominal') }}" required>
                                @error('nominal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        <!-- Keterangan -->
                            <div class="form-group col-md-12">
                                <label for="notes">Keterangan</label>
                                <input type="text" class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" value="{{ old('notes') }}">
                                @error('notes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        <!-- Metode -->
                        <div class="form-group col-md-2">
                            <label for="payment_method">Metode Transaksi</label>
                            <div class="col-md d-flex justify-content-between">
                                <input type="radio" id="tunai" name="payment_method" value="Tunai" hidden>
                                <label class="btn btn-outline-warning tunai w-100 me-1" for="tunai"> Tunai </label>
                                <input type="radio" id="transfer" name="payment_method" value="Transfer" hidden>
                                <label class="btn btn-outline-success transfer w-100" for="transfer"> Transfer </label>
                            </div>
                        </div>
                        <!-- Rekening -->
                        <div class="form-group col-md-4" id="rekening">
                            <label for="rekening_id">Rekening</label>
                            <select class="form-control bg-white text-center" name="rekening_id" id="rekening_id">
                                <option value="" selected disabled>Pilih Rekening</option>
                                @foreach ($rekenings as $rekening)
                                    <option value="{{ $rekening->id }}">{{ $rekening->bank->name }} - {{ $rekening->no_rek }} | {{ $rekening->nama }}</option>
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

<script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // minimum setup
    (function () {
        const d_week = new Datepicker(document.querySelector('#pc-datepicker-1'), {
            buttonClass: 'btn'
        });
    })();
    $(document).ready(function () {
        $("input[name='payment_method']").change(function () {
            $(".btn-outline-warning, .btn-outline-success").removeClass("active");
            $(this).next("label").addClass("active");
        });
    });

    function toggleElements() {
    const paymentMethodInput = document.querySelector('input[name="payment_method"]:checked');
  
    if (!paymentMethodInput) {
        return;
    }
  
    const paymentMethod = paymentMethodInput.value;
  
    const hideElement = (id) => {
        const element = document.getElementById(id);
        if (element) {
            element.style.display = 'none';
            element.removeAttribute('required');
        }
    };
  
    const showElement = (id) => {
        const element = document.getElementById(id);
        if (element) {
            element.style.display = 'block';
            element.setAttribute('required', 'required');
        }
    };
  
    if (paymentMethod === 'Transfer') {
        showElement('rekening');
    } 
}
</script>