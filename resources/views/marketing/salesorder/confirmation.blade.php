@extends('layout.main')

@section('container')

<div class="card">
    <div class="card-header d-flex justify-content-between bg-primary">
        <div class="iq-header-title">
            <a href="{{ url()->previous() }}" class="badge bg-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left mb-1 mt-1"></i></a>
        </div>
        <div class="iq-header-title">
            <h3 class="card-title mb-0">Sales Order</h3>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="dt-responsive table-responsive-sm">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>Tanggal Pemesanan</th>
                                <th>Nama Lembaga</th>
                                <th>Nama Customer</th>
                                <th>Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                </td>
                                <th>{{ $customer->NamaLembaga }}</th>
                                <td>{{ $customer->Jabatan }}</td>
                                <td>{{ $customer->employee->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Detail Pesanan -->
        <div class="row">
            <div class="col-sm-12">
                <div class="dt-responsive table-responsive-lg">
                    <table class="table table-striped table-bordered nowrap">
                        <thead class="light text-center">
                            <tr>
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
                                <td><h6 class="mb-0">{{ $item->name }}</h6></td>
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
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer d-flex flex-wrap justify-content-end">
        <div class="invoice-btn d-flex" data-extra-toggle="confirmation">
            @php
                $salesOrders = [
                    // ['route' => 'store.SOReguler', 'label' => 'Sales Order Reguler'],
                    // ['route' => 'store.SOHet', 'label' => 'Sales Order HET'],
                    // ['route' => 'store.SOROnline', 'label' => 'Sales Order Reguler SIPLah'],
                    // ['route' => 'store.SOHOnline', 'label' => 'Sales Order HET SIPLah']
                    ['route' => 'store.SOReguler', 'label' => 'R-Offline'],
                    ['route' => 'store.SOHet', 'label' => 'H-Offfline'],
                    ['route' => 'store.SOROnline', 'label' => 'R-Online'],
                    ['route' => 'store.SOHOnline', 'label' => 'H-Online']
                ];
            @endphp

            @foreach ($salesOrders as $order)
                <form action="{{ route($order['route']) }}" method="post" class="confirmation-form">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                    <input type="hidden" name="discount_percent" value="{{ $discount_percent }}">
                    <input type="hidden" name="discount_rp" value="{{ $discount_rp }}">
                    <input type="hidden" name="grandtotal" value="{{ $grandtotal }}">
                    <button type="button" class="btn bg-success me-3 confirm-button"><b>{{ $order['label'] }}</b></button>
                </form>
            @endforeach
        </div>
    </div>
</div>

@endsection
