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
                    <h4 class="mb-3">Daftar Tagihan</h4>
                </div>
                <div>
                    <a href="{{ route('salesorder.pendingDue') }}" class="btn btn-danger add-list"><i class="fa-solid fa-trash me-3"></i>Clear Search</a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <form action="{{ route('salesorder.pendingDue') }}" method="get">
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
                                <input type="text" id="search" class="form-control" name="search" placeholder="Search order" value="{{ request('search') }}">
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
                    <thead>
                        <tr>
                            <th width="3%">No.</th>
                            <th>Invoice No</th>
                            {{-- <th>@sortablelink('customer.name', 'Lembaga')</th> --}}
                            <th>@sortablelink('customer.name', 'Customer')</th>
                            <th>@sortablelink('created_at', 'Tanggal Pemesanan')</th>
                            <th>@sortablelink('updated_at', 'Diperbarui')</th>
                            <th>Metode Bayar</th>
                            <th>@sortablelink('dibayar')</th>
                            <th>@sortablelink('Tagihan')</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dues as $due)
                        <tr>
                            <td>{{ (($dues->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>{{ $due->invoice_no }}</td>
                            <td><b>{{ $due->customer->NamaLembaga }}</b><br><p>{{ $due->customer->NamaCustomer }} | {{ $due->customer->Jabatan }}</p></td>
                            {{-- <td>{{ $due->customer->NamaCustomer }}</td> --}}
                            <td>{{ Carbon\Carbon::parse($due->created_at)->format('d M Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($due->updated_at)->format('d M Y') }}</td>
                            {{-- <td>{{ Carbon\Carbon::parse($due->updated_at)->format('H:i:s d M Y') }}</td> --}}
                            <td>{{ $due->payment_status }}</td>
                            <td>
                                <span class="badge badge-warning text-white">
                                   Rp {{ number_format( $due->pay) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-danger text-white">
                                   Rp {{ number_format($due->due) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    {{-- <a class="btn btn-info me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Details" href="{{ route('order.orderDetails', $due->id) }}">
                                        Details
                                    </a> --}}
                                    <button type="button" class="btn btn-primary-dark me-2" data-bs-toggle="modal" data-target=".bd-example-modal-lg" id="{{ $due->id }}" onclick="payDue(this.id)">Perbarui</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $dues->links() }}
        </div>

        {{-- REKAP --}}
        {{-- <div class="col-lg-12">
            <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Jumlah</th>
                            <th>Total Grand Total</th>
                            <th>Total Dibayar</th>
                            <th>Total Tagihan</th>
                            </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $dues->count('due') }}</td>
                            <td>
                                <span class="btn btn-danger text-white">
                                   Rp {{ $dues->sum('grandtotal') }}
                                </span>
                            </td>
                            <td>
                                <span class="btn btn-danger text-white">
                                   Rp {{ $dues->sum('pay') }}
                                </span>
                            </td>
                            <td>
                                <span class="btn btn-danger text-white">
                                   Rp {{ $dues->sum('due') }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <br> --}}
              

        {{-- Rekap Total SO --}}
        <div class="col-lg-12 ml-3">
            <div class="row">
                 {{-- Jumlah Tagihan --}}
                 <div class="col-lg-4 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-success-light">
                                    <img src="../assets/images/product/2.png" class="img-fluid" alt="image">
                                </div>
                                <div>
                                    <p class="mb-2">Jumlah Tagihan</p>
                                    <h5>{{ number_format($dues->count('due')) }}</h5>
                                </div>
                            </div>
                            <div class="iq-progress-bar mt-2">
                                <span class="bg-warning iq-progress progress-1" data-percent="75">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Total Dibayar --}}
                <div class="col-lg-4 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-success-light">
                                    <img src="../assets/images/product/3.png" class="img-fluid" alt="image">
                                </div>
                                <div>
                                    <p class="mb-2">Telah Dibayar</p>
                                    <h5>Rp {{ number_format($dues->sum('pay')) }}</h5>
                                </div>
                            </div>
                            <div class="iq-progress-bar mt-2">
                                <span class="bg-danger iq-progress progress-1" data-percent="75">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Total Belum Dibayar --}}
                <div class="col-lg-4 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-info-light">
                                    <img src="../assets/images/product/2.png" class="img-fluid" alt="image">
                                </div>
                                <div>
                                    <p class="mb-2">Belum Dibayar</p>
                                    <h5>Rp {{ number_format($dues->sum('due')) }}</h5>
                                </div>
                            </div>
                            <div class="iq-progress-bar mt-2">
                                <span class="bg-success iq-progress progress-1" data-percent="85">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>

            </div>
            {{ $dues->links() }}
        </div>
    </div>
    <!-- Page end  -->
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('salesorder.updateDue') }}" method="post">
                @csrf
                <input type="hidden" name="order_id" id="order_id">
                <div class="modal-body">
                    <h3 class="modal-title text-center mx-auto">Pay Due</h3>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="due">Pay Now</label>
                            <input type="text" class="form-control bg-white @error('due') is-invalid @enderror" id="due" name="due">
                            @error('due')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Pay</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function payDue(id){
        $.ajax({
            type: 'GET',
            url : '/order/due/' + id,
            dataType: 'json',
            success: function(data) {
                $('#due').val(data.due);
                $('#order_id').val(data.id);
            }
        });
    }
</script>

@endsection
