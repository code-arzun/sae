@extends('layout.main')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><a href="{{ route('cashflow.index') }}">Arus Kas</a></li>
@endsection

@section('action-button')
    <!-- 
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahTransaksi"><i class="ti ti-plus"></i> Catat Transaksi Baru</button>
        {{-- @include('finance.cashflow.create') --}}
    -->
    <a href="{{ route('cashflowcategory.index') }}" class="btn btn-primary me-3">Kategori Transaksi</a>
@endsection

@section('container')

@if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Finance', 'Manajer Marketing']))
<ul class="nav nav-tabs mb-3" id="cashflow" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"><h5><i class="ti ti-table me-2"></i>Semua</h5></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="annual-tab" data-bs-toggle="tab" href="#annual" role="tab"><h5><i class="ti ti-table me-2"></i>Rekap Tahunan</h5></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="monthly-tab" data-bs-toggle="tab" href="#monthly" role="tab"><h5><i class="ti ti-table me-2"></i>Rekap Bulanan</h5></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="download-tab" data-bs-toggle="tab" href="#download" role="tab"><h5><i class="ti ti-download me-2"></i>Download</h5></a>
    </li>
</ul>
@endif

<div class="tab-content" id="cashflowContent">
    <!-- All Data -->
    <div class="tab-pane fade show active" id="all" role="tabpanel">
        <div class="d-flex justify-content-between mb-3">
            <button type="button" class="btn btn-success w-100 me-3" data-bs-toggle="modal" data-bs-target="#createIncome">Catat Pemasukan Baru</button>
            @include('finance.cashflow.create-income')
            <!-- Create Expenditure -->
            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#createExpenditure">Catat Pengeluaran Baru</button>
            @include('finance.cashflow.create-expenditure')
        </div>
        @include('finance.cashflow.data.all')
    </div>
    <!-- Annual Data -->
    <div class="tab-pane fade" id="annual" role="tabpanel">
        @include('finance.cashflow.data.table-annual', ['cashflows' => $cashflows])
    </div>
    <!-- Data monthly -->
    <div class="tab-pane fade" id="monthly" role="tabpanel">
        @include('finance.cashflow.data.table-monthly', ['cashflows' => $cashflows])
    </div>
    <!-- Download -->
    <div class="tab-pane fade" id="download" role="tabpanel">
        {{-- @include('finance.cashflow.data.download') --}}
    </div>
</div>

<script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function setupCashflowModal(modalSelector) {
    const $modal = $(modalSelector);

    // Toggle active class saat metode dipilih
    $modal.find("input[name='method']").change(function () {
        // Ambil ID input yang dipilih (tunai / transfer)
        const selectedId = $(this).attr('id');

        // Hapus semua label active dulu dalam modal ini
        $modal.find("label[for='tunai'], label[for='transfer']").removeClass("active");

        // Aktifkan label yang sesuai dengan input yang dipilih
        $modal.find(`label[for="${selectedId}"]`).addClass("active");

        toggleTransferFields();
    });

    function toggleTransferFields() {
        const selected = $modal.find("input[name='method']:checked").val();
        if (selected === "Transfer") {
            $modal.find("#pegawai").hide();
            $modal.find("#bank").show();
            $modal.find("#rekeningPartner").show();
            $modal.find("#namaPartner").show();
            $modal.find("#rekeningPerusahaan").show();
        } else {
            $modal.find("#pegawai").show();
            $modal.find("#bank").hide();
            $modal.find("#rekeningPartner").hide();
            $modal.find("#namaPartner").hide();
            $modal.find("#rekeningPerusahaan").hide();
        }
    }

    // Inisialisasi saat load
    toggleTransferFields();

    // Cek old value (jika modal masih render setelah validasi gagal)
    const oldMethod = "{{ old('method') }}";
    if (oldMethod === 'Transfer') {
        $modal.find("#pegawai").hide();
        $modal.find("#bank").show();
        $modal.find("#rekeningPartner").show();
        $modal.find("#namaPartner").show();
        $modal.find("#rekeningPerusahaan").show();

        // Aktifkan label transfer
        $modal.find("label[for='transfer']").addClass("active");
    } else if (oldMethod !== '') {
        $modal.find("#pegawai").show();
        $modal.find("#bank").hide();
        $modal.find("#rekeningPartner").hide();
        $modal.find("#namaPartner").hide();
        $modal.find("#rekeningPerusahaan").hide();

        // Aktifkan label tunai
        $modal.find("label[for='tunai']").addClass("active");
    }
}

// Panggil untuk masing-masing modal
$(document).ready(function () {
    setupCashflowModal("#createIncome");
    setupCashflowModal("#createExpenditure");
    setupCashflowModal("#editTransaksi");
});

</script>


@endsection
