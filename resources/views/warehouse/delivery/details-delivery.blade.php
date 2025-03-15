@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        
        <div class="col-lg-12">
            <div class="row">
                {{-- <div class="mb-3">
                    <a href="{{ route('so.proposed') }}" class="badge bg-primary"data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left"></i></a>
                </div> --}}
                {{-- <div class="col-md-9">
                    <h4 class="card-title">Informasi Detail Pesanan
                        <a class="badge 
                            {{ strpos($deliveries->invoice_no, 'SOR') !== false ? 'badge-primary' : 
                            (strpos($deliveries->invoice_no, 'SOH') !== false ? 'badge-danger' : 
                            (strpos($deliveries->invoice_no, 'SO') !== false ? 'badge-warning' : 'badge-secondary')) }}" 
                           href="{{ route('so.orderDetails', $deliveries->id) }}" 
                           data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                           {{ $deliveries->invoice_no }}
                        </a>
                    </h4>
                </div> --}}
                <div class="col-md">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="d-flex justify-content-between align-items-center list-action">
                                <a href="{{ url()->previous() }}"
                                   class="badge bg-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali">
                                   <i class="fa fa-arrow-left"></i>
                                </a>
                                @if ($deliveries->delivery_status == 'Siap dikirim')
                                @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
                                <div class="d-flex ml-auto">
                                    <form action="{{ route('do.sentStatus') }}" method="POST" class="mr-2">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $deliveries->id }}">
                                        <button type="submit" class="btn bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Kirim"><b>Kirim</b></button>
                                    </form>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Informasi Detail Pesanan</h4>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row align-items-top">
                        <div class="form-group col-md-3">
                            <label>Tanggal DO</label> <br>
                                <span class="badge bg-primary">{{Carbon\Carbon::parse($deliveries->delivery_date)->translatedformat('l, d F Y') }}</span>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Nomor</label> <br>
                                <span class="badge 
                                    {{ strpos($deliveries->invoice_no, 'DOR') !== false ? 'badge-primary' : 
                                    (strpos($deliveries->invoice_no, 'DOH') !== false ? 'badge-danger' : 
                                    (strpos($deliveries->invoice_no, 'DORS') !== false ? 'badge-success' : 
                                    (strpos($deliveries->invoice_no, 'DOHS') !== false ? 'badge-warning' : 'badge-secondary'))) }}">
                                    {{ $deliveries->invoice_no }}
                                </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Status </label> <br>
                                <span class="badge 
                                    {{ strpos($deliveries->delivery_status, 'Siap dikirim') !== false ? 'badge-warning' : 
                                       (strpos($deliveries->delivery_status, 'Dikirim') !== false ? 'badge-primary' : 
                                       (strpos($deliveries->delivery_status, 'Terkirim') !== false ? 'badge-success' : 'badge-secondary')) }}">
                                    {{ $deliveries->delivery_status }}
                                </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Nomor SO</label> <br>
                            <a class="badge 
                                    {{ strpos($deliveries->salesorder->invoice_no, 'SOR') !== false ? 'badge-primary' : 
                                    (strpos($deliveries->salesorder->invoice_no, 'SOH') !== false ? 'badge-danger' : 
                                    (strpos($deliveries->salesorder->invoice_no, 'SORS') !== false ? 'badge-success' : 
                                    (strpos($deliveries->salesorder->invoice_no, 'SOHS') !== false ? 'badge-warning' : 'badge-secondary'))) }}" 
                                    href="{{ route('so.orderDetails', $deliveries->salesorder->id) }}" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                    {{ $deliveries->salesorder->invoice_no }}
                            </a>
                        </div>
                        
                        <div class="form-group col-md-3">
                            <label>Sales</label> <br>
                                <span class="badge bg-primary">
                                {{ $deliveries->salesorder->customer->employee->name }}
                                </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Nama Customer</label>
                            <input type="text" class="form-control bg-white" value="{{ $deliveries->salesorder->customer->NamaCustomer }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Jabatan</label>
                            <input type="text" class="form-control bg-white" value="{{ $deliveries->salesorder->customer->Jabatan }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Telp.</label>
                            <input type="text" class="form-control bg-white" value="{{ $deliveries->salesorder->customer->TelpCustomer }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Alamat</label>
                            <input type="text" class="form-control bg-white" value="{{ $deliveries->salesorder->customer->AlamatCustomer }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Nama Lembaga</label>
                            <input type="text" class="form-control bg-white" value="{{ $deliveries->salesorder->customer->NamaLembaga }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Telp.</label>
                            <input type="text" class="form-control bg-white" value="{{ $deliveries->salesorder->customer->TelpLembaga }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>E-Mail</label>
                            <input type="text" class="form-control bg-white" value="{{ $deliveries->salesorder->customer->EmailLembaga }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Alamat</label>
                            <input type="text" class="form-control bg-white" value="{{ $deliveries->salesorder->customer->AlamatLembaga }}" readonly>
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
                        @foreach ($deliveryDetails as $item)
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td width="60px">
                                <img class="avatar-40 rounded" src="{{ $item->product->product_image ? asset('storage/products/'.$item->product_image) : asset('storage/products/default.webp') }}">
                            </td>
                            <td>
                                <h6>{{ $item->product->product_name }}</h6>
                                <p> {{ $item->product->category->name }}</p>
                                {{-- <h6>{{ $item->product->product_code }}</h6> --}}
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
                    <div class="or-detail rounded ">
                        <div class="bg-primary pl-3 pt-2 pb-2">
                            <h4>Total</h4>
                        </div>
                        <div class="ttl-amt py-2 px-3 d-flex justify-content-between align-items-center ">
                            <h5>Total Produk</h5>
                            <h3 class="text-primary font-weight-700">{{ $deliveries->total_products }}</h3>
                            <h5>Subtotal</h5>
                            <h3 class="text-primary font-weight-700">Rp {{ number_format($deliveries->sub_total) }}</h3>
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
