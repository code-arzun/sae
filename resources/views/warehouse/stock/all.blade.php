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
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Riwayat Stok <span class="badge bg-success">Masuk</span</h4>
                </div>
                <div>
                    <a href="{{ route('stock.all') }}" class="btn btn-danger add-list"><i class="fa-solid fa-trash me-3"></i>Clear Search</a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <form action="{{ route('stock.all') }}" method="get">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="form-group row">
                        <label for="row" class="col-sm-3 align-self-center">Row:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="row">
                                <option value="10" @if(request('row') == '10')selected="selected"@endif>10</option>
                                <option value="25" @if(request('row') == '25')selected="selected"@endif>25</option>
                                <option value="50" @if(request('row') == '50')selected="selected"@endif>50</option>
                                <option value="100" @if(request('row') == '100')selected="selected"@endif>100</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3 align-self-center" for="search">Search:</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" id="search" class="form-control" name="search" placeholder="Search stock" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="input-group-text bg-primary"><i class="fa-solid fa-magnifying-glass font-size-20"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead class="bg-white text-uppercase text-center">
                        <tr class="ligth ligth-data">
                            <th>No.</th>
                            <th>@sortablelink('stock_date', 'Tanggal Stok Masuk')</th>
                            <th>@sortablelink('invoice_no', 'Kode')</th>
                            <th>@sortablelink('supplier.name', 'Supplier')</th>
                            <th>@sortablelink('sub_total', 'Subtotal')</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @foreach ($stocks as $stock)
                        <tr>
                            <td>{{ (($stocks->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>{{ Carbon\Carbon::parse($stock->stock_date)->translatedformat('l, d F Y') }}</td>
                            <td class="text-center">
                                <a class="badge bg-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Lihat Detail"
                                        href="{{ route('stock.Details', $stock->id) }}">
                                        {{ $stock->invoice_no }}
                                </a>
                            </td>
                            <td><b>{{ $stock->supplier->name }}</b> <br></td>
                            <td class="text-end"><span class="badge bg-danger">Rp {{ number_format($stock->sub_total) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $stocks->links() }}
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
