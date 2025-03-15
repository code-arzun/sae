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
                    <a href="{{ route('collection.all') }}" class="badge bg-secondary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div class="d-flex flex-wrap align-items-top justify-content-between">
                    <h3 class="mr-3">Collection</h3>
                    @if (auth()->user()->hasAnyRole('Super Admin', 'Admin', 'Admin Gudang'))
                        <div>
                            <a href="{{ route('collection.exportData') }}" class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Excel"><i class="fa fa-file-excel"></i></a>
                        </div>
                    @endif
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

        <!-- Tabel Data -->
        <div class="col-lg-12">
            <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>@sortablelink('prder_date', 'Tgl. SO')</th>
                            <th>@sortablelink('invoice_no', 'No. SO')</th>
                            <th>@sortablelink('customer.NamaLembaga', 'Customer')</th>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                            <th>@sortablelink('customer.employee_id', 'Sales')</th>
                            @endif
                            <th>Bruto</th>
                            <th>Netto</th>
                            <th>Tagihan</th>
                            <th>Dibayar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salesorders as $salesorder)
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>
                                <a class="badge badge-primary" href="{{ route('so.orderDetails', $salesorder->id) }}" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Lihat Detail">{{ $salesorder->invoice_no }}
                                </a>
                            </td>
                            <td>
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($salesorder->order_date)->translatedformat('l, d F Y') }}">
                                    {{ Carbon\Carbon::parse($salesorder->order_date)->translatedformat('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <h6>{{ $salesorder->customer->NamaLembaga }}</h6>
                                    {{ $salesorder->customer->NamaCustomer }}
                            </td>
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                            <td>{{ $salesorder->customer->employee->name }}</td>
                            @endif
                            <td class="text-end"><span class="badge bg-success">Rp {{ number_format($salesorder->sub_total) }}</span></td>
                            <td class="text-end"><span class="badge bg-warning">Rp {{ number_format($salesorder->grandtotal) }}</span></td>
                            <td class="text-end">
                                @if ($salesorder->due > 0)
                                        <span class="badge bg-danger">Rp {{ number_format($salesorder->due) }}</span>
                                    @else
                                @endif
                            </td>
                            <td class="text-end">
                                @if ($salesorder->pay > 0)
                                        <span class="badge bg-primary">Rp {{ number_format($salesorder->pay) }}</span>
                                    @else
                                @endif
                            </td>
                            <td>
                                @if ($salesorder->payment_status === 'Belum dibayar')
                                    <span class="badge bg-danger">{{ $salesorder->payment_status }}</span>
                                @elseif ($salesorder->payment_status === 'Belum Lunas')
                                    <span class="badge bg-warning">{{ $salesorder->payment_status }}</span>
                                @else
                                    <span class="badge bg-success">{{ $salesorder->payment_status }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $salesorders->links() }}
        </div>

        <!-- Rekap -->
        <div class="col-lg-12 m-3">
            <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead class="badge-white text-uppercase">
                        <tr>
                            <th>Jumlah Transaksi</th>
                            <th>Total Subtotal (Bruto)</th>
                            <th>Total Diskon</th>
                            <th>Total Grandtotal (Nett)</th>
                            <th>Total Tagihan</th>
                            <th>Total Telah dibayar</th>
                            <th>Total Belum dibayar</th>
                        </tr>
                    </thead>
                    <tbody class="light-body text-center">
                        <tr>
                            <td>{{ $collections->count('sub_total') }}</td>
                            <td>
                                <span class="btn badge-warning text-white">
                                   Rp {{ number_format($collections->sum('sub_total')) }}
                                </span>
                            </td>
                            <td>
                                <span class="btn badge-danger text-white">
                                   Rp {{ number_format($collections->sum('discount_rp')) }}
                                </span>
                            </td>
                            <td>
                                <span class="btn badge-success text-white">
                                   Rp {{ number_format($collections->sum('grandtotal')) }}
                                </span>
                            </td>
                            <td>
                                <span class="btn badge-warning text-white">
                                   Rp {{ number_format($collections->sum('sub_total')) }}
                                </span>
                            </td>
                            <td>
                                <span class="btn badge-danger text-white">
                                   Rp {{ number_format($collections->sum('pay')) }}
                                </span>
                            </td>
                            <td>
                                <span class="btn badge-success text-white">
                                   Rp {{ number_format($collections->sum('due')) }}
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
