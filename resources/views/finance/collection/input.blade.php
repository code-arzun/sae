@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('collection.index') }}">Collection</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('input.collection') }}">Input</a></li>
@endsection

@section('specificpagestyles')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('container')

<form action="{{ route('inputCol.confirmation') }}" method="POST">
    @csrf
    <!-- Dropdown untuk memilih sales order -->
        <div class="form-group col-md-12 mb-3">
            <label for="order_id">Pilih Sales Order</label>
            <select class="form-control order_id bg-white text-center" name="order_id" id="order_id" onchange="calculateCollection()" readonly>
                @foreach ($salesorders as $salesorder)
                    <option value="{{ $salesorder->id }}" {{ request('order_id') == $salesorder->id ? 'selected' : '' }}
                        data-due="{{ $salesorder->due }}"
                        data-discount="{{ $salesorder->discount_percent }}"
                        data-customer="{{ $salesorder->customer->NamaCustomer }}">
                        {{ $salesorder->invoice_no }} | {{ $salesorder->customer->NamaLembaga }} - 
                        {{ $salesorder->customer->NamaCustomer }} | Rp {{ number_format($salesorder->due) }} | {{ $salesorder->payment_status }}  | {{ $salesorder->customer->employee->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
        </div>
    <!-- Metode Pembayaran -->
        <div class="row d-flex mb-3">
            <!-- Total Tagihan -->
                <div class="form-group col-md-2">
                    <label for="data-due">Total Tagihan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-danger text-white">Rp</span>
                        <input type="number" class="form-control text-center bg-danger text-white" id="data-due" name="data-due" value="{{ number_format($salesorder->due) }}" readonly>
                    </div>
                </div>
            <!-- Dibayar oleh -->
                <div class="form-group col-md-2">
                    <label for="paid_by">Dibayar oleh</label>
                    <div class="input-group">
                        <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Dibayar oleh Customer" id="paidByCustomer"><i class="ti ti-user-check"></i></button>
                        <input type="text" class="form-control text-center @error('paid_by') is-invalid @enderror" id="paid_by" name="paid_by" value="{{ old('paid_by') }}" required>
                    </div>
                </div>
                @error('paid_by')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            <!-- Metode Pembayaran -->
                <div class="form-group col-md-2">
                    <label for="payment_method">Metode Pembayaran</label>
                    <div class="col-md d-flex justify-content-between">
                        <input type="radio" id="tunai" name="payment_method" value="Tunai" hidden>
                        <label class="btn btn-outline-warning tunai w-100 me-1" for="tunai"> Tunai </label>
                        <input type="radio" id="transfer" name="payment_method" value="Transfer" hidden>
                        <label class="btn btn-outline-success transfer w-100" for="transfer"> Transfer </label>
                    </div>
                </div>
            <!-- Diterima oleh -->
                <div class="form-group col-md" id="penerima" style="display: none;">
                    <label for="received_by">Diterima oleh</label>
                    <select class="form-control bg-white text-center  @error('received_by') is-invalid @enderror" name="received_by" id="received_by">
                        <option value="" selected disabled>Pilih Penerima</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('received_by')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            
                <div class="col-md">
                    <div class="row">
                        <!-- Bank Pengirim -->
                            <div class="form-group col-md-3" id="bankPengirim" style="display: none;">
                                <label for="bank">Bank Pengirim</label>
                                <select class="form-control bg-white text-center" name="bank" id="bank">
                                    <option value="" selected disabled>Pilih Bank</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                            </div>
            
                        <!-- Nomor Rekening -->
                            <div class="form-group col-md-5" id="rekeningPengirim" style="display: none;">
                                <label for="no_rek">Rekening Pengirim</label>
                                <input type="text" class="form-control text-center" id="no_rek" name="no_rek" value="{{ old('no_rek') }}">
                            </div>
            
                        <!-- Rekening Penerima -->
                            <div class="form-group col-md-4" id="rekeningPenerima" style="display: none;">
                                <label for="transfer_to">Rekening Penerima</label>
                                <select class="form-control bg-white text-center" name="transfer_to" id="transfer_to">
                                {{-- <label for="rekening_id">Rekening Penerima</label>
                                <select class="form-control bg-white text-center" name="rekening_id" id="rekening_id"> --}}
                                    <option value="" selected disabled>Pilih Rekening Penerima</option>
                                    @foreach ($rekenings as $rekening)
                                        <option value="{{ $rekening->id }}">{{ $rekening->bank->name }} - {{ $rekening->no_rek }} | {{ $rekening->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
                </div>
        </div>
    <!-- Nominal Pembayaran -->
        <div class="row d-flex flex-wrap">
            <!-- Input untuk pembayaran -->
            <div class="form-group col-md">
                <label for="pay">Nominal Pembayaran</label>
                {{-- <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Bayar penuh sesuai jumlah tagihan" id="fullPay">100%</button>
                        <button type="button" class="btn btn-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Bayar penuh sesuai jumlah tagihan" id="pay75%">75%</button>
                        <button type="button" class="btn btn-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Bayar penuh sesuai jumlah tagihan" id="pay50%">50%</button>
                        <button type="button" class="btn btn-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Bayar penuh sesuai jumlah tagihan" id="pay25%">25%</button>
                        <span class="input-group-text">Rp</span>
                    </div>
                    <input type="number" class="form-control text-center @error('pay') is-invalid @enderror" id="pay" name="pay" value="{{ old('pay', 0) }}" oninput="calculateCollection()" required>
                </div> --}}
                <div class="input-group mb-3">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pilih Jumlah</button>
                    <span class="input-group-text">Rp</span>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" id="fullPay">Bayar Penuh</a>
                        <a class="dropdown-item" href="#" id="pay75%">75%</a>
                        <a class="dropdown-item" href="#" id="pay50%">50%</a>
                        <a class="dropdown-item" href="#" id="pay25%">25%</a>
                    </div>
                    <input type="number" class="form-control text-center @error('pay') is-invalid @enderror" id="pay" name="pay" value="{{ old('pay', 0) }}" oninput="calculateCollection()" required>
                </div>
            </div>
            @error('pay')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            <!-- Input untuk diskon (persen) -->
            <div class="col-md-4">
                <div class="row">
                    <div class="form-group">
                        <label for="discount_percent">Diskon </label>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="input-group col-md-5 mb-3">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Diskon sesuai Sales Order" id="discount">%</button>
                                    <input type="number" step="0.01"  class="form-control text-center" id="discount_percent" name="discount_percent" value="{{ old('discount_percent', 0) }}" oninput="calculateCollection()">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="input-group col-md mb-3">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control text-center bg-white" id="discount_rp" name="discount_rp" value="{{ old('discount_rp', 0) }}" aria-label="Amount (to the nearest Rupiah)" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Input untuk PPh22 (persen) -->
            <div class="col-md-4">
                <div class="row">
                    <div class="form-group">
                        <label for="PPh22_percent">PPh22 </label>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="input-group col-md-6 mb-3">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="PPh22" id="PPh22">0,5%</button>
                                    <input type="number" step="0.01"  class="form-control text-center" id="PPh22_percent" name="PPh22_percent" value="{{ old('PPh22_percent', 0) }}" oninput="calculateCollection()">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="input-group col-md mb-3">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control text-center bg-white" id="PPh22_rp" name="PPh22_rp" value="{{ old('PPh22_rp', 0) }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Biaya-biaya -->
        <div class="row d-flex flex-wrap">
            <!-- Input untuk PPN (persen) -->
            <div class="col-md-4">
                <div class="row">
                    <div class="form-group">
                        <label for="PPN_percent">PPN </label>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="input-group col-md-5 mb-3">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="PPN" id="PPN">11%</button>
                                    <input type="number" step="0.01"  class="form-control text-center" id="PPN_percent" name="PPN_percent" value="{{ old('PPN_percent', 0) }}" oninput="calculateCollection()">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="input-group col-md mb-3">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control text-center bg-white" id="PPN_rp" name="PPN_rp" value="{{ old('PPN_rp', 0) }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Input untuk biaya admin -->
                <div class="form-group col-md-4">
                    <label for="admin_fee">Biaya Admin</label>
                    <div class="input-group col-md">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" class="form-control text-center" id="admin_fee" name="admin_fee" value="{{ old('admin_fee', 0) }}" oninput="calculateCollection()">
                    </div>
                </div>

            <!-- Input untuk biaya lain-lain -->
                <div class="form-group col-md-4">
                    <label for="other_fee">Biaya Lain-Lain</label>
                    <div class="input-group col-md">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" class="form-control text-center" id="other_fee" name="other_fee" value="{{ old('other_fee', 0) }}" oninput="calculateCollection()">
                    </div>
                </div>
        </div>
    <!-- Status & Total Akhir -->
        <div class="row d-flex flex-wrap">
            <!-- Status Pembayaran -->
                <div class="form-group col-md-2" id="status">
                    <label for="payment_status">Status Pembayaran</label>
                    <div class="col">
                        <input type="radio" value="Belum Dibayar" id="belum_dibayar" name="payment_status" hidden>
                            <label class="col-md btn btn-outline-danger belum_dibayar me-2" for="belum_dibayar" id="labelBelumDibayar">Belum Dibayar</label>
                        <input type="radio" value="Belum Lunas" id="belum_lunas" name="payment_status" value="Belum Lunas" hidden>
                            <label class="col-md btn btn-outline-warning belum_lunas me-2" for="belum_lunas" id="labelBelumLunas">Belum Lunas</label>
                        <input type="radio" value="Lunas" id="lunas" name="payment_status" value="Lunas" hidden>
                            <label class="col-md btn btn-outline-success lunas" for="lunas" id="labelLunas">Lunas</label>
                    </div>
                </div>
            <!-- Output untuk tagihan -->
                <div class="form-group col-md">
                    <label for="due">Sisa Tagihan</label>
                    <div class="input-group col-md">
                        <span class="input-group-text bg-danger text-white">Rp</span>
                        <input type="number" class="form-control text-center font-weight-bold bg-danger text-white" id="due" name="due" value="{{ old('due', 0) }}" readonly>
                    </div>
                </div>
            <!-- Output untuk total akhir -->
                <div class="form-group col-md">
                    <label for="grandtotal">Total Akhir Diterima</label>
                    <div class="input-group col-md">
                        <span class="input-group-text bg-success text-white">Rp</span>
                        <input type="number" class="form-control text-center font-weight-bold bg-success text-white" id="grandtotal" name="grandtotal" value="{{ old('grandtotal', 0) }}" readonly>
                    </div>
                </div>
        </div>
        <div class="row-md-12 mt-3 mb-5">
            <button type="submit" class="btn btn-success w-100"><b>Buat Collection</b></button>
        </div>
    </form>
</div>

{{-- @include('components.preview-img-form') --}}
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $("input[name='payment_method']").change(function () {
            $(".btn-outline-warning, .btn-outline-success").removeClass("active");
            $(this).next("label").addClass("active");
        });
    });
</script>