@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-9">
                    <h4 class="card-title">Informasi Stock Order <button class="btn btn-primary"><b>{{ $stocks->invoice_no }}</b></button></h4>
                </div>
                {{-- <div class="col-md">
                    @if ($stocks->stock_status == 'Diterima')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex align-items-center list-action">
                                    <form action="{{ route('stock.updateStatus') }}" method="POST" style="margin-bottom: 5px">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $stocks->id }}">
                                        <button type="submit" class="btn btn-success me-2 border-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Konfirmasi">Konfirmasi</button>

                                        <a class="btn btn-danger me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel" href="{{ route('stock.pendingStock') }}">Batalkan</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div> --}}
            </div>
            <div class="card">
                <div class="card-body">
                    <!-- begin: Show Data -->
                    <div class="form-group row align-items-center">
                        <div class="col-md-12">
                            <div class="profile-img-edit">
                                <div class="crm-profile-img-edit">
                                    <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="{{ $stocks->supplier->photo ? asset('storage/customers/'.$stock->customer->photo) : asset('storage/customers/default.png') }}" alt="profile-pic">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="form-group col-md-2">
                            <label>Nama Supplier</label>
                            <input type="text" class="form-control bg-white" value="{{ $stocks->supplier->name }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Jabatan</label>
                            <input type="text" class="form-control bg-white" value="{{ $stocks->supplier->shopname }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tanggal Pemesanan</label>
                            <input type="text" class="form-control bg-white" value="{{Carbon\Carbon::parse($stocks->stock_date)->translatedformat('l, d F Y') }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Nomor</label>
                            <input class="form-control bg-white" id="buying_date" value="{{ $stocks->invoice_no }}" readonly/>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Metode Pembayaran</label>
                            <input class="form-control bg-white" id="expire_date" value="{{ $stocks->payment_status }}" readonly />
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>


        <!-- end: Show Data -->
        <div class="col-lg-12">
            <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th colspan="2">Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stockDetails as $item)
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td width="60px">
                                <img class="avatar-40 rounded" src="{{ $item->product->product_image ? asset('storage/products/'.$item->product_image) : asset('storage/products/default.webp') }}">
                            </td>
                            <td>
                                <h6>{{ $item->product->product_name }}</h6>
                                <p> {{ $item->product->category->name }}</p>
                                <h6>{{ $item->product->product_code }}</h6>
                            </td>
                            <td style="text-align: center">{{ number_format($item->quantity) }}</td>
                            <td style="text-align: right">Rp {{ number_format($item->unitcost) }}</td>
                            <td style="text-align: right">Rp {{ number_format($item->total) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row mb-5">
                <div class="offset-lg-6 col-lg-6">
                    <div class="or-detail rounded">
                        <div class="ttl-amt py-2 px-3 d-flex justify-content-between align-items-center">
                            <h6>Total Produk</h6>
                            <h3 class="text-primary font-weight-700">{{ number_format($stocks->total_products) }}</h3>
                            <h6>Subtotal</h6>
                            <h3 class="text-primary font-weight-700">Rp {{ number_format($stocks->sub_total) }}</h3>
                        </div>
                        <div colspan="4" class="ttl-amt py-2 px-3 d-flex justify-content-between align-items-center">
                            <h6>Diskon</h6>
                            <h3 class="text-primary font-weight-700">{{ number_format($stocks->discount) }} %</h3>
                            <h3 class="text-primary font-weight-700">Rp {{ number_format($stocks->discount) }}</h3>
                        </div>
                        <div class="ttl-amt py-2 px-3 d-flex justify-content-between align-items-center">
                            <h6>Grand Total</h6>
                            <h3 class="text-primary font-weight-700">Rp {{ number_format($stocks->grandtotal) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- Page end  -->
</div>

@include('components.preview-img-form')
@endsection
