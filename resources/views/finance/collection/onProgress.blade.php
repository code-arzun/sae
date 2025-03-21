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
                    <a href="{{ route('collection.unpaid') }}" class="badge bg-secondary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div>
                    <h5>
                        Collection
                        <div class="btn-group ml-1">
                            <a class="btn bg-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <b>Belum Lunas</b>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left">
                                <a class="dropdown-item" href="{{ route('collection.all') }}">Semua</a>
                                <a class="dropdown-item" href="{{ route('collection.unpaid') }}">Belum dibayar</a>
                                <a class="dropdown-item" href="{{ route('collection.paid') }}">Lunas</a>
                            </div>
                        </div>
                    </h5>
                </div>
            </div>
        </div>

        <!-- Row & Pencarian -->
        <div class="col-lg-12">
            <form action="{{ route('collection.all') }}" method="get">
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
                            <option value="SOR-" @if(request('order_invoice_no') == 'SOR-') selected="selected" @endif>SO Reguler</option>
                            <option value="SOH-" @if(request('order_invoice_no') == 'SOH-') selected="selected" @endif>SO HET</option>
                            <option value="SORS" @if(request('order_invoice_no') == 'SORS') selected="selected" @endif>SO Reguler Online</option>
                            <option value="SOHS" @if(request('order_invoice_no') == 'SOHS') selected="selected" @endif>SO HET Online</option>
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
                            <th>@sortablelink('payment_date', 'Tgl. Col')</th>
                            <th>@sortablelink('invoice_no', 'No. Col')</th>
                            <th>@sortablelink('order_date', 'Tgl. SO')</th>
                            <th>@sortablelink('invoice_no', 'No. SO')</th>
                            <th>@sortablelink('customer.NamaLembaga', 'Customer')</th>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                            <th>@sortablelink('customer.employee_id', 'Sales')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collections as $collection)
                        <tr>
                            <td>{{ (($collections->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($collection->collection_date)->translatedformat('l, d F Y') }}">
                                    {{ Carbon\Carbon::parse($collection->collection_date)->translatedformat('d M Y') }}
                                </span>
                            </td>
                            <td><a class="badge badge-primary" href="{{ route('collection.details', $collection->id) }}" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">{{ $collection->invoice_no }}</a></td>
                            <td>
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($collection->salesorder->order_date)->translatedformat('l, d F Y') }}">
                                    {{ Carbon\Carbon::parse($collection->salesorder->order_date)->translatedformat('d M Y') }}
                                </span>
                            </td>
                            <td><a class="badge badge-success" href="{{ route('so.orderDetails', $collection->order_id) }}" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">{{ $collection->salesorder->invoice_no }}</a></td>
                            <td><b>{{ $collection->salesorder->customer->NamaLembaga }}</b> <br>
                                {{ $collection->salesorder->customer->NamaCustomer }}
                            </td>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                            <td>{{ $collection->salesorder->customer->employee->name }}</td>
                            @endif
                            {{-- <td class="text-end">Rp {{ number_format($collection->sub_total) }}</td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $collections->links() }}
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
