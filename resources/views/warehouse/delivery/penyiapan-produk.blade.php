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
            <div class="d-flex flex-wrap align-items-top justify-content-between mb-3">
                <div>
                    <a href="{{ url()->previous() }}" class="badge bg-primary mb-3 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left mb-1 mt-1"></i></a>
                    <a href="{{ route('do.penyiapanProduk') }}" class="badge bg-secondary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div>
                    <h5>Penyiapan Produk</h5>
                </div>
            </div>
        </div>

        {{-- Row & Pencarian --}}
        <div class="col-lg-12">
            <form action="{{ route('do.penyiapanProduk') }}" method="get">
                <div class="row align-items-start">
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
                            onkeyup="this.form.submit()" placeholder="Ketik disini untuk melakukan pencarian!" value="{{ request('search') }}">
                    </div>
                </div>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="col-lg-12">
            <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@sortablelink('order_date', 'Tanggal Pemesanan')</th>
                            <th>@sortablelink('invoice_no', 'No. SO')</th>
                            <th>@sortablelink('customer.NamaLembaga', 'Nama Lembaga')</th>
                            <th>@sortablelink('employee_id', 'Sales')</th>
                            <th>Cetak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prepares as $prepare)
                        <tr>
                            <td>{{ (($prepares->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($prepare->order_date)->translatedformat('l, d F Y') }}">
                                    {{ Carbon\Carbon::parse($prepare->order_date)->translatedformat('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <a class="badge badge-primary" href="{{ route('so.orderDetails', $prepare->id) }}" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">{{ $prepare->invoice_no }}</a>
                            </td>
                            <td><b>{{ $prepare->customer->NamaLembaga }}</b> <br>
                                {{ $prepare->customer->NamaCustomer }}
                            </td>
                            <td>{{ $prepare->customer->employee->name }}</td>
                            <td>
                                <a class="btn btn-warning me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak"
                                        href="{{ route('do.printPenyiapan', $prepare->id) }}">
                                        <i class="fa fa-print me-0" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $prepares->links() }}
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
