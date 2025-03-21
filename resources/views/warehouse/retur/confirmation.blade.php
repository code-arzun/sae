@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-block">
                <div class="card-header d-flex justify-content-between bg-primary">
                    <div class="iq-header-title">
                        <a href="{{ url()->previous() }}" class="badge bg-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left mb-1 mt-1"></i></a>
                    </div>
                    <div class="iq-header-title">
                        <h3 class="card-title mb-0">Retur Order</h3>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="dt-responsive table-responsive-sm">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">Tanggal Retur</th>
                                            <th scope="col">No. DO</th>
                                            <th scope="col">Tanggal DO</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Sales</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $deliveryorder->delivery_date }}</td>
                                            <td>
                                                <a class="badge 
                                                    {{ strpos($deliveryorder->invoice_no, 'DOR') !== false ? 'badge-primary' : 
                                                    (strpos($deliveryorder->invoice_no, 'DOH') !== false ? 'badge-danger' : 
                                                    (strpos($deliveryorder->invoice_no, 'DO') !== false ? 'badge-warning' : 'badge-secondary')) }}" 
                                                    href="{{ route('so.orderDetails', $deliveryorder->id) }}" 
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                                    {{ $deliveryorder->invoice_no }}
                                                </a>
                                            </td>
                                            <td>{{ $deliveryorder->delivery_date }}</td>
                                            <td>
                                                <h6>{{ $deliveryorder->salesorder->customer->NamaLembaga }}</h6>
                                                <p>{{ $deliveryorder->salesorder->customer->NamaCustomer }} | {{ $deliveryorder->salesorder->customer->Jabatan }}</p>
                                            </td>
                                            <td>{{ $deliveryorder->salesorder->customer->employee->name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pesanan -->
                    <div class="row">
                        <div class="col-sm-12">
                            {{-- <h5 class="mb-3">Detail Pesanan</h5> --}}
                            <div class="dt-responsive table-responsive-lg">
                                <table class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            {{-- <th>No.</th> --}}
                                            <th>Nama Produk</th>
                                            <th>Kategori</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($content as $item)
                                        <tr>
                                            {{-- <td class="text-center" scope="row">{{ $loop->iteration }}</td> --}}
                                            <td>
                                                <h6 class="mb-0">{{ $item->name }}</h6>
                                            </td>
                                            <td class="text-center">{{ $item->category }}</td>
                                            <td class="text-center">{{ number_format($item->qty) }}</td>
                                            <td class="text-center">Rp {{ number_format($item->price) }}</td>
                                            <td class="text-center"><b>Rp {{ number_format($item->subtotal) }}</b></td>
                                        </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                                
                                <table class="table table-striped table-bordered nowrap">
                                    <tr>
                                        <th>Total Item<span class="badge bg-secondary ml-2">{{ number_format(count(Cart::content())) }}</span></th>
                                        <th>Total Barang<span class="badge bg-primary ml-2">{{ number_format(Cart::count()) }}</span></th>
                                        <th>Subtotal<span class="badge bg-success ml-2">Rp {{ number_format(Cart::subtotal()) }}</span></th>
                                        <th>Diskon
                                            <span class="badge bg-secondary ml-2">{{ number_format($discount_percent) }} %</span>
                                            <span class="badge bg-secondary">Rp {{ number_format($discount_rp) }}</span>
                                        </th>
                                        <th>Grand Total<span class="badge bg-primary ml-2">Rp {{ number_format($grandtotal) }}</span></th>
                                    </tr>
                                    {{-- <tr class="text-end">
                                        <th>Total Item<span class="badge bg-secondary ml-2">{{ number_format(count(Cart::content())) }}</span></th>
                                        <th>Total Barang<span class="badge bg-primary ml-2">{{ number_format(Cart::count()) }}</span></th>
                                        <th>Subtotal<span class="badge bg-success ml-2">Rp {{ number_format(Cart::subtotal()) }}</span></th>
                                        </tr>
                                        <tr class="text-end">
                                            <th colspan="2">Diskon
                                                <span class="badge bg-primary ml-2">{{ number_format($discount_percent) }} %</span>
                                            </th>
                                            <th>
                                                <span class="badge bg-secondary">Rp {{ number_format($discount_rp) }}</span>
                                            </th>
                                        </tr>
                                        <tr class="text-end">
                                            <th colspan="2">Grand Total</th>
                                            <th><span class="badge bg-primary ml-2">Rp {{ number_format($grandtotal) }}</span></th>
                                    </tr> --}}
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="card-footer d-flex flex-wrap justify-content-end">
                        <div class="invoice-btn d-flex" data-extra-toggle="confirmation">
                            @php
                                $returOrders = [
                                    ['route' => 'store.ROReguler', 'label' => 'ROR'],
                                    ['route' => 'store.ROHet', 'label' => 'ROH'],
                                    ['route' => 'store.ROROnline', 'label' => 'RORS'],
                                    ['route' => 'store.ROHOnline', 'label' => 'ROHS']
                                ];
                            @endphp
    
                            @foreach ($returOrders as $retur)
                                <form action="{{ route($retur['route']) }}" method="post" class="confirmation-form">
                                    @csrf
                                    <input type="hidden" name="delivery_id" value="{{ $deliveryorder->id }}">
                                    <input type="hidden" name="discount_percent" value="{{ $discount_percent }}">
                                    <input type="hidden" name="discount_rp" value="{{ $discount_rp }}">
                                    <input type="hidden" name="grandtotal" value="{{ $grandtotal }}">
                                    <button type="button" class="btn bg-success me-3 confirm-button"><b>{{ $retur['label'] }}</b></button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
