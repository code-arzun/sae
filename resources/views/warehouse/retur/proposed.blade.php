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
                    <a href="{{ route('retur.proposed') }}" class="badge bg-secondary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div>
                    <h5 class="mb-3">
                        Retur Order
                        <div class="btn-group ml-0">
                            <a class="btn bg-warning dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <b>Diajukan</b>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('retur.all') }}">Semua</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('retur.approved') }}">Disetujui</a>
                                <a class="dropdown-item" href="{{ route('retur.cancelled') }}">Dibatalkan</a>
                                <a class="dropdown-item" href="{{ route('retur.declined') }}">Ditolak</a>
                            </div>
                        </div>
                    </h5>
                    {{-- <h5 class="mb-3">Sales Order<span class="badge bg-warning ml-2">Diajukan</span></h5> --}}
                </div>
            </div>
        </div>

        <!-- Row & Pencarian -->
        <div class="col-lg-12">
            <form action="{{ route('retur.proposed') }}" method="get">
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
        <div class="col-lg-12 dt-responsive table-responsive mb-5">
            <div class="dt-responsive table-responsive mb-5">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>@sortablelink('order_date', 'Tanggal Retur')</th>
                            <th>@sortablelink('invoice_no', 'No. Retur')</th>
                            <th>@sortablelink('order_date', 'Tanggal DO')</th>
                            <th>@sortablelink('invoice_no', 'No. DO')</th>
                            <th>@sortablelink('customer.name', 'Customer')</th>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing']))
                            <th>@sortablelink('customer.employee_id', 'Sales')</th>
                            @endif
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                            <th>#</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($returs as $propose)
                        <tr>
                            <td>{{ (($returs->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($propose->retur_date)->translatedformat('l, d F Y') }}">
                                    {{ Carbon\Carbon::parse($propose->retur_date)->translatedformat('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <a class="badge 
                                    {{ strpos($propose->invoice_no, 'ROR') !== false ? 'badge-primary' : 
                                    (strpos($propose->invoice_no, 'ROH') !== false ? 'badge-danger' : 
                                    (strpos($propose->invoice_no, 'RO') !== false ? 'badge-warning' : 'badge-secondary')) }}" 
                                   href="{{ route('retur.Details', $propose->id) }}" 
                                   data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                   {{ $propose->invoice_no }}
                                </a>
                            </td>
                            <td>
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($propose->delivery->delivery_date)->translatedformat('l, d F Y') }}">
                                    {{ Carbon\Carbon::parse($propose->delivery->delivery_date)->translatedformat('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <a class="badge badge-primary" href="{{ route('do.deliveryDetails', $propose->delivery->id) }}" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">{{ $propose->delivery->invoice_no }}</a></td>
                            <td><h6>{{ $propose->delivery->salesorder->customer->NamaLembaga }}</h6> {{ $propose->delivery->salesorder->customer->NamaCustomer }}</td>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing']))
                            <td>{{ $propose->delivery->salesorder->customer->employee->name }}</td>
                            @endif
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <!-- Setujui -->
                                    <form action="{{ route('retur.approvedStatus') }}" method="POST" class="confirmation-form">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $propose->id }}">
                                        <button type="button" class="btn btn-success me-2 update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="Setujui">
                                             <i class="fa fa-check me-0" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                    <!-- Tolak -->
                                    <form action="{{ route('retur.declinedStatus') }}" method="POST" class="confirmation-form">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $propose->id }}">
                                        <button type="button" class="btn btn-danger me-2 update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="Tolak">
                                            <i class="fa fa-dot-circle-o me-0" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                    <!-- Batalkan -->
                                    <form action="{{ route('retur.cancelledStatus') }}" method="POST" class="confirmation-form">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $propose->id }}">
                                        <button type="button" class="btn btn-warning update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="Batalkan">
                                            <i class="fa fa-times me-0" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
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
