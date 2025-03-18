@extends('layout.main')

@section('container')

<div class="d-flex justify-content-between mb-3">
    <div>
        <h2>{{ $title }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-default-icon">
                @include('marketing.salesorder.partials.breadcrumb')
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('input.so') }}">Input</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('inputso.confirmation') }}">Konfirmasi</a></li>
            </ol>
        </nav>
    </div>
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
                <button type="submit" class="btn bg-success me-3 confirm-button"><b>{{ $order['label'] }}</b></button>
            </form>
        @endforeach
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">Tanggal</span>
                <h4 class="mb-0"></h4>
            </div>
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">Nama Lembaga</span>
                <h4 class="mb-0">{{ $customer->NamaLembaga }}</h4>
            </div>
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">Nama Customer</span>
                <h4 class="mb-0">{{ $customer->NamaCustomer }}</h4>
            </div>
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">Jabatan</span>
                <h4 class="mb-0">{{ $customer->Jabatan }}</h4>
            </div>
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">Sales</span>
                <h4 class="mb-0">{{ $customer->employee->name }}</h4>
            </div>
        </div>
        {{-- <table class="table text-center">
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
                    {{ $customer->NamaLembaga }}
                    {{ $customer->Jabatan }}
                    {{ $customer->employee->name }}
                </tr>
            </tbody>
        </table> --}}

        <!-- Detail Pesanan -->
        <table class="table table-striped nowrap">
            <thead class="bg-info text-center">
                <tr>
                    <th class="text-white">Nama Produk</th>
                    <th class="text-white" width="250px">Kategori</th>
                    <th class="text-white" width="150px">Harga</th>
                    <th class="text-white" width="150px">Jumlah</th>
                    <th class="text-white" width="150px">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($content as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category }}</td>
                    <th class="text-end">Rp {{ number_format($item->price) }}</th>
                    <th class="text-end">{{ number_format($item->qty) }}</th>
                    <th class="text-end">Rp {{ number_format($item->subtotal) }}</th>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="offset-lg-8">
            <table class="table text-end">
                <tr>
                    <th>Total Item</th>
                    <th><span class="badge bg-secondary w-100"> {{ number_format(count(Cart::content())) }}</span></th>
                    <th>Total Barang</th>
                    <th><span class="badge bg-secondary w-100"> {{ number_format(Cart::count()) }}</span></th>
                    <th>Subtotal</th>
                    <th><span class="badge bg-success w-100">Rp {{ number_format(Cart::subtotal()) }}</span></th>
                </tr>
                <tr>
                    <td colspan="4">Diskon</td>
                    <th>{{ number_format($discount_percent) }} %</th>
                    <th><span class="badge bg-danger w-100">Rp {{ number_format($discount_rp) }}</span></th>
                </tr>
                <tr>
                    <td colspan="5">Grand Total</td>
                    <th><span class="badge bg-primary w-100">Rp {{ number_format($grandtotal) }}</span></th>
                </tr>
            </table>
        </div>
    </div>

    {{-- <div class="card-footer d-flex flex-wrap justify-content-end">
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
    </div> --}}
</div>

@endsection
