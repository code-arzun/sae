@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-block">
                <div class="card-header d-flex justify-content-between bg-primary">
                    <div class="iq-header-title">
                        <h4 class="card-title mb-0">Barang Masuk</h4>
                    </div>
                    <div class="invoice-btn d-flex">
                        <form action="{{ route('inputstock.storeStock') }}" method="post">
                            @csrf
                            <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
                            <input type="hidden" name="stock_status" value="Diterima">
                            <button type="submit" class="btn btn-success">Buat Stok Masuk</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="dt-responsive table-responsive-sm">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Tanggal Barang Masuk</th>
                                            <th scope="col">Stock Status</th>
                                            <th scope="col">Diterima dari</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ Carbon\Carbon::now()->format('M d, Y') }}</td>
                                            <td><span class="badge badge-danger">Unpaid</span></td>
                                            <td>
                                                <p class="mb-0">{{ $supplier->name }}<br>
                                                   {{ $supplier->Jabatan }}<br>
                                                    {{ $supplier->AlamatCustomer }}<br>
                                                    {{ $supplier->TelpCustomer }}<br>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0">{{ $supplier->NamaLembaga }}<br>
                                                   {{ $supplier->AlamatLembaga }}<br>
                                                    {{ $supplier->TelpLembaga }}<br>
                                                    {{ $supplier->EmailLembaga }}<br>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="mb-3">Order Summary</h5>
                            <div class="dt-responsive table-responsive-lg">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center" scope="col">#</th>
                                            <th scope="col">Item</th>
                                            <th class="text-center" scope="col">Jumlah</th>
                                            <th class="text-center" scope="col">Harga</th>
                                            <th class="text-center" scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($content as $item)
                                        <tr>
                                            <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                <h6 class="mb-0">{{ $item->name }}</h6>
                                            </td>
                                            <td class="text-center">{{ $item->qty }}</td>
                                            <td class="text-center">Rp {{ $item->price }}</td>
                                            <td class="text-center"><b>Rp {{ $item->subtotal }}</b></td>
                                        </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 mb-3">
                        <div class="offset-lg-8 col-lg-4">
                            <div class="or-detail rounded">
                                <div class="p-3">
                                    <h5 class="mb-3">Order Details</h5>
                                    <div class="mb-2">
                                        <h6>Sub Total</h6>
                                        <p>Rp {{ Cart::subtotal() }}</p>
                                    </div>
                                    <div>
                                        <h6>Diskon</h6>
                                        <p>Rp </p>
                                    </div>
                                </div>
                                <div class="ttl-amt py-2 px-3 d-flex justify-content-between align-items-center">
                                    <h6>Total</h6>
                                    <h3 class="text-primary font-weight-700">Rp {{ Cart::grandtotal() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
