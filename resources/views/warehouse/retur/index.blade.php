@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('retur.index') }}">Retur</a></li>
@endsection

@section('action-button')
    @if (auth()->user()->hasAnyRole('Super Admin', 'Admin', 'Admin Gudang', 'Manajer Marketing'))
        {{-- <a href="{{ route('do.exportData') }}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Excel">
            <i class="fa fa-file-excel me-2"></i>
            Download Excel
        </a> --}}
    @endif
@endsection

@section('container')

<div class="row">
    
    <!-- Row & Pencarian -->
    <div class="col-lg-12">
        <form action="" method="get">
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
                        <th>Tgl. Retur</th>
                        <th>No. Retur</th>
                        <th>Tgl. DO</th>
                        <th>No. DO</th>
                        <th>Customer</th>
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                        <th>Sales</th>
                        @endif
                        {{-- <th>@sortablelink('sub_total', 'Subtotal')</th> --}}
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($returs as $retur)
                    <tr>
                        <td>
                            <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($retur->retur_date)->translatedformat('l, d F Y') }}">
                                {{ Carbon\Carbon::parse($retur->retur_date)->translatedformat('d M Y') }}
                            </span>
                        </td>
                        <td>
                            <a class="badge bg-danger" href="{{ route('retur.Details', $retur->id) }}" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Retur">
                                {{ $retur->invoice_no }}
                            </a>
                        </td>
                        <td>
                            <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($retur->delivery->delivery_date)->translatedformat('l, d F Y') }}">
                                {{ Carbon\Carbon::parse($retur->delivery->delivery_date)->translatedformat('d M Y') }}
                            </span>
                        </td>
                        <td>
                            <a class="badge bg-primary" href="{{ route('do.deliveryDetails', $retur->delivery_id) }}" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail DO">
                                {{ $retur->delivery->invoice_no }}
                            </a>
                        </td>
                        <td>
                            <b>{{ $retur->delivery->salesorder->customer->NamaLembaga }}</b> <br>
                            {{ $retur->delivery->salesorder->customer->NamaCustomer }}
                        </td>
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                        <th data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $retur->delivery->salesorder->customer->employee->name }}">
                            {{ explode(' ', $retur->delivery->salesorder->customer->employee->name)[0] }}
                        </th>
                        @endif
                        {{-- <td class="text-end">Rp {{ number_format($retur->sub_total) }}</td> --}}
                        {{-- @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin'])) --}}
                        <td class="text-center">
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
                                @if ($retur->retur_status === 'Menunggu persetujuan Manajer Marketing')
                                    <a href="#" class="badge bg-danger w-100" data-bs-toggle="modal" data-bs-target="#sent{{ $retur->id }}">{{ $retur->retur_status }}</a>
                                    {{-- @include('warehouse.retur.partials.modal-sent') --}}
                                @elseif ($retur->retur_status === 'Disetujui Manajer Marketing')
                                    <a href="#" class="badge bg-warning w-100" data-bs-toggle="modal" data-bs-target="#delivered{{ $retur->id }}">{{ $retur->retur_status }}</a>
                                    {{-- @include('warehouse.retur.partials.modal-delivered') --}}
                                @else
                                    <span class="badge bg-success w-100">{{ $retur->retur_status }}</span>
                                @endif
                            @else
                                @if ($retur->retur_status === 'Menunggu persetujuan Manajer Marketing')
                                    <span class="badge bg-danger w-100">{{ $retur->retur_status }}</span>
                                @elseif ($retur->retur_status === 'Dalam Pengiriman')
                                    <span class="badge bg-warning w-100">{{ $retur->retur_status }}</span>
                                @else
                                    <span class="badge bg-success w-100">{{ $retur->retur_status }}</span>
                                @endif
                            @endif
                        </td>
                        {{-- @endif --}}
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
