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
                    <a href="{{ route('so.proposed') }}" class="badge bg-secondary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div>
                    <h5 class="mb-3">
                        Sales Order
                        <div class="btn-group ml-0">
                            <a class="btn bg-warning dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <b>Diajukan</b>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('so.index') }}">Semua</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('so.approved') }}">Disetujui</a>
                                <a class="dropdown-item" href="{{ route('so.sent') }}">Dalam Pengiriman</a>
                                <a class="dropdown-item" href="{{ route('so.delivered') }}">Terkirim</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('so.cancelled') }}">Dibatalkan</a>
                                <a class="dropdown-item" href="{{ route('so.declined') }}">Ditolak</a>
                            </div>
                        </div>
                    </h5>
                    {{-- <h5 class="mb-3">Sales Order<span class="badge bg-warning ml-2">Diajukan</span></h5> --}}
                </div>
            </div>
        </div>

        {{-- Row & Pencarian --}}
        <div class="col-lg-12">
            <form action="{{ route('so.proposed') }}" method="get">
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
                    <div class="form-group col-sm-2">
                        <select name="invoice_no" id="invoice_no" class="form-control"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan jenis SO" onchange="this.form.submit()">
                            <option selected disabled>-- Pilih Kode SO --</option>
                            <option value="" @if(request('invoice_no') == 'null') selected="selected" @endif>Semua</option>
                            <option value="SOR-" @if(request('invoice_no') == 'SOR-') selected="selected" @endif>SO Reguler</option>
                            <option value="SOH-" @if(request('invoice_no') == 'SOH-') selected="selected" @endif>SO HET</option>
                            <option value="SORS" @if(request('invoice_no') == 'SORS') selected="selected" @endif>SO Reguler Online</option>
                            <option value="SOHS" @if(request('invoice_no') == 'SOHS') selected="selected" @endif>SO HET Online</option>
                        </select>
                    </div>
                    <div class="form-group col-sm">
                        <input type="text" id="search" class="form-control" name="search" 
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Ketik untuk melakukan pencarian!"
                            onblur="this.form.submit()" placeholder="Ketik disini untuk melakukan pencarian!" value="{{ request('search') }}">
                    </div>
                </div>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="col-lg-12">
            <div class="dt-responsive table-responsive mb-5">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@sortablelink('order_date', 'Tanggal Pemesanan')</th>
                            <th>@sortablelink('invoice_no', 'No. SO')</th>
                            <th>@sortablelink('customer.name', 'Customer')</th>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing']))
                            <th>
                                @sortablelink('customer.employee_id', 'Sales')
                            </th>
                            @endif
                            <th>@sortablelink('sub_total', 'Subtotal')</th>
                            <th>@sortablelink('discount', 'Diskon')</th>
                            <th>@sortablelink('grandtotal', 'Grand Total')</th>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $propose)
                        <tr>
                            <td>{{ (($orders->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($propose->order_date)->translatedformat('l, d F Y') }}">
                                    {{ Carbon\Carbon::parse($propose->order_date)->translatedformat('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <a class="badge 
                                    {{ strpos($propose->invoice_no, 'SOR') !== false ? 'badge-primary' : 
                                    (strpos($propose->invoice_no, 'SOH') !== false ? 'badge-danger' : 
                                    (strpos($propose->invoice_no, 'SO') !== false ? 'badge-warning' : 'badge-secondary')) }}" 
                                   href="{{ route('so.orderDetails', $propose->id) }}" 
                                   data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                   {{ $propose->invoice_no }}
                                </a>
                            </td>
                            <td><h6>{{ $propose->customer->NamaLembaga }}</h6> {{ $propose->customer->NamaCustomer }}</td>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing']))
                            <td>{{ $propose->customer->employee->name }}</td>
                            @endif
                            <td class="text-end"><span class="badge bg-success">Rp {{ number_format($propose->sub_total) }}</span></td>
                            <td class="text-end"><span class="badge bg-warning">{{ number_format($propose->discount_percent, 2) }}%</span> <span class="badge bg-danger">Rp {{ number_format($propose->discount_rp) }}</span></td>
                            <td class="text-end"><span class="badge bg-primary">Rp {{ number_format($propose->grandtotal) }}</span></td>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <!-- Setujui -->
                                    <form action="{{ route('so.approvedStatus') }}" method="POST" class="confirmation-form">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $propose->id }}">
                                        <button type="button" class="btn btn-success me-2 update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Setujui">
                                             <i class="fa fa-check me-0" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                    <!-- Tolak -->
                                    <form action="{{ route('so.declinedStatus') }}" method="POST" class="confirmation-form">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $propose->id }}">
                                        <button type="button" class="btn btn-danger me-2 update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Tolak">
                                            <i class="fa fa-dot-circle-o me-0" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                    <!-- Batalkan -->
                                    <form action="{{ route('so.cancelledStatus') }}" method="POST" class="confirmation-form">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $propose->id }}">
                                        <button type="button" class="btn btn-warning update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Batalkan">
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
            {{ $orders->links() }}
        </div>

         {{-- Rekap --}}
         <div class="col-lg-12 m-3">
            {{-- <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Jumlah</th>
                            <th>Total Subtotal (Bruto)</th>
                            <th>Total Diskon</th>
                            <th>Total Grandtotal (Nett)</th>
                            </tr>
                    </thead>
                    <tbody class="light-body text-center">
                        <tr>
                            <td>{{ $orders->count('order_status', 'proposed') }}</td>
                            <td>
                                <span class="btn btn-warning text-white">
                                   Rp {{ number_format($orders->sum('sub_total')) }}
                                </span>
                            </td>
                            <td>
                                <span class="btn btn-danger text-white">
                                   Rp {{ number_format($orders->sum('discount_rp')) }}
                                </span>
                            </td>
                            <td>
                                <span class="btn btn-success text-white">
                                   Rp {{ number_format($orders->sum('grandtotal')) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
           

            </div> --}}
            {{-- {{ $orders->links() }} --}}
        </div>

    </div>
    <!-- Page end  -->
</div>

@endsection
