@extends('layout.main')

@section('container')

<div class="d-flex justify-content-between mb-3">
    <div>
        <h2>{{ $title }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-default-icon">
                @include('finance.collection.partials.breadcrumb')
            </ol>
        </nav>
    </div>
    <div>
        @if (auth()->user()->hasAnyRole('Super Admin', 'Admin', 'Admin Gudang', 'Manajer Marketing'))
        <a href="{{ route('collection.exportData') }}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Excel">
            <i class="fa fa-file-excel me-2"></i>
            Download Excel
        </a>
        @endif
    </div>
</div>

<!-- Row & Pencarian -->
<div class="col-lg-12">
    <form action="#" method="get">
        <div class="row align-items-start">
            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
            <div class="form-group col-sm-3">
                <select name="employee_id" id="employee_id" class="form-control"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Sales" onchange="this.form.submit()">
                    <option selected disabled>-- Pilih Sales --</option>
                    <option value="" @if(request('employee_id') == 'null') selected="selected" @endif>Semua</option>
                    @foreach($sales as $employee)
                    <option value="{{ $employee->employee_id }}" {{ request('employee_id') == $employee->employee_id ? 'selected' : '' }}>
                        {{ $employee->employee->name }} <!-- Adjust this to display employee's name or other details -->
                    </option>
                @endforeach
                </select>
            </div>
            @endif
            <div class="form-group col-sm-3">
                <select name="collection_invoice_no" id="collection_invoice_no" class="form-control"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan jenis SO" onchange="this.form.submit()">
                    <option selected disabled>-- Pilih Kode Col --</option>
                    <option value="" @if(request('collection_invoice_no') == 'null') selected="selected" @endif>Semua</option>
                    <option value="COR-" @if(request('collection_invoice_no') == 'COR-') selected="selected" @endif>Col Reguler</option>
                    <option value="COH-" @if(request('collection_invoice_no') == 'COH-') selected="selected" @endif>Col HET</option>
                    <option value="CORS" @if(request('collection_invoice_no') == 'CORS') selected="selected" @endif>Col Reguler Online</option>
                    <option value="COHS" @if(request('collection_invoice_no') == 'COHS') selected="selected" @endif>Col HET Online</option>
                </select>
            </div>
            <div class="form-group col-sm-3">
                <select name="order_invoice_no" id="order_invoice_no" class="form-control"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan jenis SO" onchange="this.form.submit()">
                    <option selected disabled>-- Pilih Kode SO --</option>
                    <option value="" @if(request('order_invoice_no') == 'null') selected="selected" @endif>Semua</option>
                    <option value="RO" @if(request('invoice_no') == 'RO') selected="selected" @endif>SO Reguler</option>
                    <option value="HO" @if(request('invoice_no') == 'HO') selected="selected" @endif>SO HET</option>
                    <option value="RS" @if(request('invoice_no') == 'RS') selected="selected" @endif>SO Reguler Online</option>
                    <option value="HS" @if(request('invoice_no') == 'HS') selected="selected" @endif>SO HET Online</option>
                </select>
            </div>
            <div class="form-group col-sm">
                <input type="text" id="search" class="form-control" name="search" 
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Ketik untuk melakukan pencarian!"
                    onkeyup="this.form.submit()" placeholder="Ketik disini untuk melakukan pencarian!" value="{{ request('search') }}">
            </div>
        </div>
    </form>
</div>

<ul class="nav nav-tabs mb-3" id="collection" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"><h5><i class="ti ti-table me-2"></i>Data</h5></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="datarecap-tab" data-bs-toggle="tab" href="#datarecap" role="tab"><h5><i class="ti ti-table me-2"></i>Rekap Data</h5></a>
    </li>
</ul>
<div class="tab-content" id="collectionContent">
    <!-- All Data -->
    <div class="tab-pane fade show active" id="all" role="tabpanel">
        @include('finance.collection.data.table')
    </div>
    <!-- Data Recap -->
    <div class="tab-pane fade" id="datarecap" role="tabpanel">
        @include('finance.collection.data.recap')
    </div>
</div>

<!-- Tabel Data -->




@endsection
