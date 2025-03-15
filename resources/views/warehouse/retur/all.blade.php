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
                    <a href="{{ route('retur.all') }}" class="badge bg-secondary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div>
                    <h5>
                        <div class="btn-group me-1">
                            <a class="btn bg-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <b>Semua</b>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left">
                                <a class="dropdown-item" href="{{ route('retur.proposed') }}">Diajukan</a>
                                <a class="dropdown-item" href="{{ route('retur.declined') }}">Ditolak</a>
                                <a class="dropdown-item" href="{{ route('retur.cancelled') }}">Dibatalkan</a>
                            </div>
                        </div>
                        Retur
                    </h5>
                </div>
            </div>
        </div>

        <!-- Row & Pencarian -->
        <div class="col-lg-12">
            <form action="{{ route('retur.all') }}" method="get">
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

        <div class="col-lg-12">
            <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>@sortablelink('retur_date', 'Tgl. Retur')</th>
                            <th>@sortablelink('invoice_no', 'No. Retur')</th>
                            <th>@sortablelink('delivery_date', 'Tgl. DO')</th>
                            <th>@sortablelink('invoice_no', 'No. DO')</th>
                            <th>@sortablelink('customer.NamaLembaga', 'Customer')</th>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                            <th>@sortablelink('customer.employee_id', 'Sales')</th>
                            @endif
                            {{-- <th>@sortablelink('sub_total', 'Subtotal')</th> --}}
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($returs as $retur)
                        <tr>
                            <td>{{ (($returs->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($retur->delivery_date)->translatedformat('l, d F Y') }}">
                                    {{ Carbon\Carbon::parse($retur->delivery_date)->translatedformat('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <a class="badge badge-primary" href="{{ route('retur.Details', $retur->id) }}" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Lihat Detail">{{ $retur->invoice_no }}</a>
                            </td>
                            <td>
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($retur->delivery->delivery_date)->translatedformat('l, d F Y') }}">
                                    {{ Carbon\Carbon::parse($retur->delivery->delivery_date)->translatedformat('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <a class="badge badge-primary" href="{{ route('do.deliveryDetails', $retur->delivery_id) }}" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Lihat Detail">{{ $retur->delivery->invoice_no }}</a>
                            </td>
                            <td>
                                <b>{{ $retur->delivery->salesorder->customer->NamaLembaga }}</b> <br>
                                {{ $retur->delivery->salesorder->customer->NamaCustomer }}
                            </td>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                            <td>{{ $retur->delivery->salesorder->customer->employee->name }}</td>
                            @endif
                            {{-- <td class="text-end">Rp {{ number_format($retur->sub_total) }}</td> --}}
                            {{-- @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin'])) --}}
                            <td>
                                @if ($retur->retur_status === 'Diajukan')
                                        <a href="{{ route('retur.proposed')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Buka Halaman Retur Diajukan"
                                        class="badge bg-warning">{{ $retur->retur_status }}</a>
                                    @elseif ($retur->retur_status === 'Disetujui')
                                        <a href="{{ route('retur.approved')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Buka Halaman Retur Disetujui"
                                        class="badge bg-success">{{ $retur->retur_status }}</a>
                                    @elseif ($retur->retur_status === 'Ditolak')
                                        <a href="{{ route('retur.declined')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Buka Halaman Retur Ditolak"
                                        class="badge bg-danger">{{ $retur->retur_status }}</a>
                                    @else
                                        <a href="{{ route('retur.cancelled')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Buka Halaman Retur Dibatalkan"
                                        class="badge bg-danger">{{ $retur->retur_status }}</a>
                                    @endif
                            </td>
                            {{-- @endif --}}
                            
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
