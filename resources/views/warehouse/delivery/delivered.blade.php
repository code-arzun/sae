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
                    <a href="{{ route('do.delivered') }}" class="badge bg-secondary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div>
                    <h5 class="mb-3">
                        Delivery Order
                        <div class="btn-group ml-0">
                            <a class="btn bg-success dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <b>Terkirim</b>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('do.ready') }}">Siap Kirim</a>
                                <a class="dropdown-item" href="{{ route('do.sent') }}">Dalam Pengiriman</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('do.all') }}">Semua</a>
                            </div>
                        </div>
                    </h5>
                </div>
            </div>
        </div>

      {{-- Row & Pencarian --}}
      <div class="col-lg-12">
        <form action="{{ route('do.delivered') }}" method="get">
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
                    <select name="delivery_invoice_no" id="delivery_invoice_no" class="form-control"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan jenis SO" onchange="this.form.submit()">
                        <option selected disabled>-- Pilih Kode DO --</option>
                        <option value="" @if(request('delivery_invoice_no') == 'null') selected="selected" @endif>Semua</option>
                        <option value="DOR-" @if(request('delivery_invoice_no') == 'DOR-') selected="selected" @endif>DO Reguler</option>
                        <option value="DOH-" @if(request('delivery_invoice_no') == 'DOH-') selected="selected" @endif>DO HET</option>
                        <option value="DORS" @if(request('delivery_invoice_no') == 'DORS') selected="selected" @endif>DO Reguler Online</option>
                        <option value="DOHS" @if(request('delivery_invoice_no') == 'DOHS') selected="selected" @endif>DO HET Online</option>
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
                            <th>@sortablelink('delivery_date', 'Tanggal DO')</th>
                            <th>@sortablelink('invoice_no', 'No. DO')</th>
                            <th>@sortablelink('delivery_date', 'Tanggal SO')</th>
                            <th>@sortablelink('invoice_no', 'No. SO')</th>
                            <th>@sortablelink('customer.NamaLembaga', 'Customer')</th>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                            <th>@sortablelink('customer.employee_id', 'Sales')</th>
                            @endif
                            {{-- <th>@sortablelink('sub_total', 'Subtotal')</th> --}}
                            <th>Cetak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deliveries as $delivered)
                        <tr>
                            <td>{{ (($deliveries->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($delivered->delivery_date)->translatedformat('l, d F Y') }}">
                                    {{ Carbon\Carbon::parse($delivered->delivery_date)->translatedformat('d M Y') }}
                                </span>
                            </td>
                            <td><a class="badge badge-primary" href="{{ route('do.deliveryDetails', $delivered->id) }}" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Lihat Detail">{{ $delivered->invoice_no }}</a></td>
                            <td>
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($delivered->salesorder->order_date)->translatedformat('l, d F Y') }}">
                                    {{ Carbon\Carbon::parse($delivered->salesorder->order_date)->translatedformat('d M Y') }}
                                </span>
                            </td>
                            <td><a class="badge badge-success" href="{{ route('so.orderDetails', $delivered->order_id) }}" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Lihat Detail">{{ $delivered->salesorder->invoice_no }}</a></td>
                            <td><b>{{ $delivered->salesorder->customer->NamaLembaga }}</b> <br>
                                {{ $delivered->salesorder->customer->NamaCustomer }}
                            </td>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                            <td>{{ $delivered->salesorder->customer->employee->name }}</td>
                            @endif
                            {{-- <td class="text-end">Rp {{ number_format($delivered->sub_total) }}</td> --}}
                            <td>
                                <a href="{{ route('do.invoiceDownload', $delivered->id) }}"
                                    class="btn bg-warning me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Cetak Dokumen">
                                    <i class="fa fa-print me-0" aria-hidden="true"></i> 
                                </a>
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $deliveries->links() }}
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
