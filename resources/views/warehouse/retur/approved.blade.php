@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @if (session()->has('success'))
                <div class="alert text-white bg-success" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            <div class="d-flex flex-wrap align-items-top justify-content-between">
                <div>
                    <a href="{{ url()->previous() }}" class="badge bg-primary mb-3 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left mb-1 mt-1"></i></a>
                    <a href="{{ route('retur.approved') }}" class="badge bg-secondary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div>
                    <h5 class="mb-3">
                        Retur Order
                        <div class="btn-group ml-0">
                            <a class="btn bg-success dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <b>Disetujui</b>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('retur.all') }}">Semua</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('retur.proposed') }}">Diajukan</a>
                                <a class="dropdown-item" href="{{ route('retur.cancelled') }}">Dibatalkan</a>
                                <a class="dropdown-item" href="{{ route('retur.declined') }}">Ditolak</a>
                            </div>
                        </div>
                    </h5>
                    {{-- <h5 class="mb-3">Sales Order<span class="badge bg-success ml-2">Disetujui</span></h5> --}}
                </div>
            </div>
        </div>

        <!-- Row & Pencarian -->
        <div class="col-lg-12">
            <form action="{{ route('retur.approved') }}" method="get">
                <div class="row align-items-start">
                    @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                    <div class="form-group col-sm-2">
                        <select name="employee_id" id="employee_id" class="form-control"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Sales" onchange="this.form.submit()">
                            <option selected disabled>-- Sales --</option>
                            <option value="" @if(request('employee_id') == 'null') selected="selected" @endif>Semua</option>
                            @foreach($sales as $employee)
                            <option value="{{ $employee->employee_id }}" {{ request('employee_id') == $employee->employee_id ? 'selected' : '' }}>
                                {{ $employee->employee->name }} <!-- Adjust this to display employee's name or other details -->
                            </option>
                        @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="form-group col-sm-2">
                        <select name="retur_invoice_no" id="retur_invoice_no" class="form-control"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan jenis SO" onchange="this.form.submit()">
                            <option selected disabled>-- Kode Retur --</option>
                            <option value="" @if(request('retur_invoice_no') == 'null') selected="selected" @endif>Semua</option>
                            <option value="ROR-" @if(request('retur_invoice_no') == 'ROR-') selected="selected" @endif>RO Reguler</option>
                            <option value="ROH-" @if(request('retur_invoice_no') == 'ROH-') selected="selected" @endif>RO HET</option>
                            <option value="RORS" @if(request('retur_invoice_no') == 'RORS') selected="selected" @endif>RO Reguler Online</option>
                            <option value="ROHS" @if(request('retur_invoice_no') == 'ROHS') selected="selected" @endif>RO HET Online</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <select name="delivery_invoice_no" id="delivery_invoice_no" class="form-control"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan jenis SO" onchange="this.form.submit()">
                            <option selected disabled>-- Kode DO --</option>
                            <option value="" @if(request('delivery_invoice_no') == 'null') selected="selected" @endif>Semua</option>
                            <option value="DOR-" @if(request('delivery_invoice_no') == 'DOR-') selected="selected" @endif>DO Reguler</option>
                            <option value="DOH-" @if(request('delivery_invoice_no') == 'DOH-') selected="selected" @endif>DO HET</option>
                            <option value="DORS" @if(request('delivery_invoice_no') == 'DORS') selected="selected" @endif>DO Reguler Online</option>
                            <option value="DOHS" @if(request('delivery_invoice_no') == 'DOHS') selected="selected" @endif>DO HET Online</option>
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

        <!-- Tabel -->
        <div class="col-lg-12">
            <div class="dt-responsive table-responsive mb-5">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@sortablelink('order_date', 'Tanggal Retur')</th>
                            <th>@sortablelink('invoice_no', 'No. Retur')</th>
                            <th>@sortablelink('order_date', 'Tanggal DO')</th>
                            <th>@sortablelink('invoice_no', 'No. DO')</th>
                            <th>@sortablelink('customer.name', 'Customer')</th>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing']))
                            <th>@sortablelink('customer.employee_id', 'Sales')</th>
                            @endif
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($returs as $approve)
                        <tr>
                            <td>{{ (($returs->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($approve->order_date)->translatedformat('l, d F Y') }}">
                                    {{ Carbon\Carbon::parse($approve->order_date)->translatedformat('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <a class="badge 
                                    {{ strpos($approve->invoice_no, 'ROR') !== false ? 'badge-primary' : 
                                    (strpos($approve->invoice_no, 'ROH') !== false ? 'badge-danger' : 
                                    (strpos($approve->invoice_no, 'RO') !== false ? 'badge-warning' : 'badge-secondary')) }}" 
                                   href="{{ route('retur.Details', $approve->id) }}" 
                                   data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                   {{ $approve->invoice_no }}
                                </a>
                            </td>
                            <td>
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($approve->delivery->delivery_date)->translatedformat('l, d F Y') }}">
                                    {{ Carbon\Carbon::parse($approve->delivery->delivery_date)->translatedformat('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <a class="badge badge-primary" href="{{ route('do.deliveryDetails', $approve->delivery->id) }}" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Lihat Detail">{{ $approve->delivery->invoice_no }}</a></td>
                            <td><h6>{{ $approve->delivery->salesorder->customer->NamaLembaga }}</h6>{{ $approve->delivery->salesorder->customer->NamaCustomer }}</td>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing']))
                            <td>{{ $approve->delivery->salesorder->customer->employee->name }}</td>
                            @endif
                            <td>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $returs->links() }}
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
