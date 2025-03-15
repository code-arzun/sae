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
                    <a href="{{ route('do.all') }}" class="badge bg-secondary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div class="d-flex flex-wrap align-items-top justify-content-between">
                    <h3 class="mr-3">Delivery Order</h3>
                    @if (auth()->user()->hasAnyRole('Super Admin', 'Admin', 'Admin Gudang'))
                        <div>
                            <a href="{{ route('do.exportData') }}" class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Excel"><i class="fa fa-file-excel"></i></a>
                        </div>
                        @endif
                </div>
            </div>
        </div>

        <!-- Row & Pencarian -->
        <div class="col-lg-12">
            <form action="{{ route('do.all') }}" method="get">
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

        <!-- Data -->
        <div class="col-lg-12">
            <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>@sortablelink('delivery_date', 'Tgl. DO')</th>
                            <th>@sortablelink('invoice_no', 'No. DO')</th>
                            <th>@sortablelink('sub_total', 'Subtotal')</th>
                            <th>@sortablelink('prder_date', 'Tgl. SO')</th>
                            <th>@sortablelink('invoice_no', 'No. SO')</th>
                            <th>@sortablelink('customer.NamaLembaga', 'Customer')</th>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                            <th>@sortablelink('customer.employee_id', 'Sales')</th>
                            @endif
                            {{-- <th>@sortablelink('sub_total', 'Subtotal')</th> --}}
                            <th>Terpacking</th>
                            <th>Dikirim</th>
                            <th>Terkirim</th>
                            <th>Status</th>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                            <th>#</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deliveries as $delivery)
                        <tr>
                            <td>{{ (($deliveries->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($delivery->delivery_date)->translatedformat('l, d F Y') }}">
                                    {{ Carbon\Carbon::parse($delivery->delivery_date)->translatedformat('d M Y') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-between">
                                    {{-- <a class="badge bg-primary" href="{{ route('do.deliveryDetails', $delivery->id) }}" 
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Lihat Detail">{{ $delivery->invoice_no }}
                                    </a> --}}
                                    <a class="badge {{ strpos($delivery->invoice_no, '-RO') !== false ? 'badge-primary' : (strpos($delivery->invoice_no, '-HO') !== false ? 'badge-danger' : 
                                        (strpos($delivery->invoice_no, '-RS') !== false ? 'badge-success' : (strpos($delivery->invoice_no, '-HS') !== false ? 'badge-warning' : 'badge-secondary'))) }}" 
                                        href="{{ route('do.deliveryDetails', $delivery->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Pesanan">
                                        {{ $delivery->invoice_no }}
                                    </a>
                                    @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                                        <a href="{{ route('do.invoiceDownload', $delivery->id) }}" class="btn bg-warning me-2" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="" data-original-title="Cetak Dokumen DO"><i class="fa fa-print me-0" aria-hidden="true"></i> 
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="text-end"><span class="badge badge-purple">Rp {{ number_format($delivery->sub_total) }}</span></td>
                            <td>
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($delivery->salesorder->order_date)->translatedformat('l, d F Y') }}">
                                    {{ Carbon\Carbon::parse($delivery->salesorder->order_date)->translatedformat('d M Y') }}
                                </span>
                            </td>
                            <td>
                                {{-- <a class="badge bg-success" href="{{ route('so.orderDetails', $delivery->order_id) }}" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Lihat Detail">{{ $delivery->salesorder->invoice_no }}
                                </a> --}}
                                <a class="badge {{ strpos($delivery->salesorder->invoice_no, '-RO') !== false ? 'badge-primary' : (strpos($delivery->salesorder->invoice_no, '-HO') !== false ? 'badge-danger' : 
                                    (strpos($delivery->salesorder->invoice_no, '-S') !== false ? 'badge-success' : (strpos($delivery->salesorder->invoice_no, '-HS') !== false ? 'badge-warning' : 'badge-secondary'))) }}" 
                                    href="{{ route('so.orderDetails', $delivery->salesorder->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Pesanan">
                                    {{ $delivery->salesorder->invoice_no }}
                                </a>
                            </td>
                            <td>
                                <h6>{{ $delivery->salesorder->customer->NamaLembaga }}</h6>
                                    {{ $delivery->salesorder->customer->NamaCustomer }}
                            </td>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                            <td>{{ $delivery->salesorder->customer->employee->name }}</td>
                            @endif
                            {{-- <td class="text-end">Rp {{ number_format($delivery->sub_total) }}</td> --}}
                            {{-- @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin'])) --}}
                            <td class="text-center">{{ $delivery->packed_at ? Carbon\Carbon::parse($delivery->packed_at)->translatedFormat('H:i - l, d M Y') : '' }}</td>
                            <td class="text-center">{{ $delivery->sent_at ? Carbon\Carbon::parse($delivery->sent_at)->translatedFormat('H:i - l, d M Y') : '' }}</td>
                            <td class="text-center">{{ $delivery->delivered_at ? Carbon\Carbon::parse($delivery->delivered_at)->translatedFormat('H:i - l, d M Y') : '' }}</td>
                            <td class="text-center">
                                @if ($delivery->delivery_status === 'Siap dikirim')
                                        <span class="badge bg-danger">{{ $delivery->delivery_status }}</span>
                                    @elseif ($delivery->delivery_status === 'Dalam Pengiriman')
                                        <span class="badge bg-warning">{{ $delivery->delivery_status }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $delivery->delivery_status }}</span>
                                @endif
                                {{-- @if ($delivery->delivery_status === 'Siap dikirim')
                                        <a href="{{ route('do.ready')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Buka Halaman DO Siap Dikirim"
                                        class="badge bg-danger">{{ $delivery->delivery_status }}</a>
                                    @elseif ($delivery->delivery_status === 'Dikirim')
                                        <a href="{{ route('do.sent')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Buka Halaman DO Dikirim"
                                        class="badge bg-warning">{{ $delivery->delivery_status }}</a>
                                    @else
                                        <a href="{{ route('do.delivered')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Buka Halaman DO Terkirim"
                                        class="badge bg-success">{{ $delivery->delivery_status }}</a>
                                @endif --}}
                            </td>
                            {{-- @endif --}}
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <!-- Kirim -->
                                        @if ($delivery->delivery_status === 'Siap dikirim')
                                            <form action="{{ route('do.sentStatus') }}" method="POST" class="confirmation-form">
                                                @method('put')
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $delivery->id }}">
                                                <button type="button" class="btn bg-success update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Kirim">
                                                    <i class="fa fa-truck me-0" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        @elseif ($delivery->delivery_status === 'Dalam Pengiriman')
                                        <!-- Terkirim -->
                                            <form action="{{ route('do.deliveredStatus') }}" method="POST" class="confirmation-form">
                                                @method('put')
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $delivery->id }}">
                                                <button type="button" class="btn btn-success me-2 update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Terkirim">
                                                    <i class="fa fa-check me-0" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $deliveries->links() }}
        </div>

        <!-- Rekap -->
        <div class="col-lg-12 m-3">
            <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead class="badge-white text-uppercase">
                        <tr>
                            <th>Jumlah Transaksi</th>
                            <th>Terpacking</th>
                            <th>Dalam Pengiriman</th>
                            <th>Terkirim</th>
                            <th>Total Subtotal (Bruto)</th>
                        </tr>
                    </thead>
                    <tbody class="light-body text-center">
                        <tr>
                            <td>{{ $deliveries->count('sub_total') }}</td>
                            <td>
                                <span class="btn badge-info text-white">
                                    {{ $deliveries->whereNotNull('packed_at')->whereNull('sent_at')->whereNull('delivered_at')->count() }}
                                </span>
                            </td>
                            <td>
                                <span class="btn badge-warning text-white">
                                    {{ $deliveries->whereNotNull('sent_at')->whereNull('delivered_at')->count() }}
                                </span>
                            </td>
                            <td>
                                <span class="btn badge-success text-white">
                                    {{ $deliveries->whereNotNull('delivered_at')->count() }}
                                </span>
                            </td>
                            <td>
                                <span class="btn badge-warning text-white">
                                   Rp {{ number_format($deliveries->sum('sub_total')) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
           
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
