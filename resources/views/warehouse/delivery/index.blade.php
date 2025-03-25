@extends('layout.main')

@section('container')

<div class="d-flex justify-content-between mb-3">
    <div>
        <h2>{{ $title }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-default-icon">
                @include('warehouse.delivery.partials.breadcrumb')
            </ol>
        </nav>
    </div>
    <div>
        @if (auth()->user()->hasAnyRole('Super Admin', 'Admin', 'Admin Gudang', 'Manajer Marketing'))
        <a href="{{ route('do.exportData') }}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Excel">
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
            <div class="form-group col-sm-2">
                <select class="form-control" name="delivery_status"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Status Pengiriman" onchange="this.form.submit()">
                    <option selected disabled>-- Status Pengiriman --</option>
                    <option value="" @if(request('delivery_status') == 'null') selected="selected" @endif>Semua</option>
                    @foreach ($deliveryStatus as $status)
                        <option value="{{ $status }}" {{ request('delivery_status') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
            <div class="form-group col-sm-2">
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
            <div class="form-group col-sm-1">
                <select name="delivery_invoice_no" id="delivery_invoice_no" class="form-control"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan jenis SO" onchange="this.form.submit()">
                    <option selected disabled>-- Pilih Kode DO --</option>
                    <option value="" @if(request('delivery_invoice_no') == 'null') selected="selected" @endif>Semua</option>
                    <option value="RO" @if(request('invoice_no') == 'RO') selected="selected" @endif>DO Reguler</option>
                    <option value="HO" @if(request('invoice_no') == 'HO') selected="selected" @endif>DO HET</option>
                    <option value="RS" @if(request('invoice_no') == 'RS') selected="selected" @endif>DO Reguler Online</option>
                    <option value="HS" @if(request('invoice_no') == 'HS') selected="selected" @endif>DO HET Online</option>
                </select>
            </div>
            <div class="form-group col-sm-1">
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

<ul class="nav nav-tabs mb-3" id="delivery" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"><h5><i class="ti ti-table me-2"></i>Data</h5></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="datarecap-tab" data-bs-toggle="tab" href="#datarecap" role="tab"><h5><i class="ti ti-table me-2"></i>Rekap Data</h5></a>
    </li>
</ul>
<div class="tab-content" id="deliveryContent">
    <!-- All Data -->
    <div class="tab-pane fade show active" id="all" role="tabpanel">
        @include('warehouse.delivery.data.table')
    </div>
    <!-- Data Recap -->
    <div class="tab-pane fade" id="datarecap" role="tabpanel">
        @include('warehouse.delivery.data.recap')
    </div>
</div>

@endsection
