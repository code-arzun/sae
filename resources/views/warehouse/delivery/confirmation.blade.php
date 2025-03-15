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
                        <h3 class="card-title mb-0"><i class="fa fa-truck me-3"></i>Delivery Order</h3>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Tanggal Pemesanan & Data Customer -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="dt-responsive table-responsive-sm">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">No. SO</th>
                                            <th scope="col">Tanggal Pemesanan</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Sales</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a class="badge {{ strpos($salesorder->invoice_no, 'SOR') !== false ? 'badge-primary' : 
                                                        (strpos($salesorder->invoice_no, 'SOH') !== false ? 'badge-danger' : 
                                                        (strpos($salesorder->invoice_no, 'SO') !== false ? 'badge-warning' : 'badge-secondary')) }}" 
                                                        href="{{ route('so.orderDetails', $salesorder->id) }}" 
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                                    {{ $salesorder->invoice_no }}
                                                </a>
                                            </td>
                                            <td>{{ $salesorder->order_date }}</td>
                                            <td>
                                                <h6>{{ $salesorder->customer->NamaLembaga }}</h6>
                                                <p>{{ $salesorder->customer->NamaCustomer }} | {{ $salesorder->customer->Jabatan }}</p>
                                            </td>
                                            <td>{{ $salesorder->customer->employee->name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pesanan -->
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="mb-3">Detail Pesanan</h5>
                            <div class="dt-responsive table-responsive-lg">
                                <table class="table table-striped table-bordered nowrap">
                                    <thead class="light text-center">
                                        <tr>
                                            <th scope="col">Nama Produk</th>
                                            <th scope="col">Kategori</th>
                                            <th class="text-center" scope="col">Jumlah</th>
                                            <th class="text-center" scope="col">Harga</th>
                                            <th class="text-center" scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($content as $item)
                                        <tr>
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

                                <!-- Total -->
                                <table class="table table-striped table-bordered nowrap">
                                    <tr class="light text-end">
                                        <th>Total Item<span class="badge bg-secondary ml-2">{{ number_format(count(Cart::content())) }}</span></th>
                                        <th>Total Barang<span class="badge bg-primary ml-2">{{ number_format(Cart::count()) }}</span></th>
                                        <th>Subtotal<span class="badge bg-success ml-2">Rp {{ number_format(Cart::subtotal()) }}</span></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <div class="form-group col-sm-2">
                        <select class="form-control @error('shipping_status') is-invalid @enderror" name="shipping_status">
                            <option value="" selected disabled>-- Pilih Pengiriman --</option>
                            <option value="Pengiriman ke-1">Pengiriman ke-1</option>
                            <option value="Pengiriman ke-2">Pengiriman ke-2</option>
                            <option value="Pengiriman ke-3">Pengiriman ke-3</option>
                            <option value="Pengiriman ke-4">Pengiriman ke-4</option>
                            <option value="Pengiriman ke-5">Pengiriman ke-5</option>
                        </select>
                        @error('shipping_status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="invoice-btn d-flex" data-extra-toggle="confirmation">
                        {{-- @php
                            $deliveryOrders = [
                                @if ()
                                ['route' => 'store.DOReguler', 'label' => 'R-Offline'],
                                ['route' => 'store.DOHet', 'label' => 'H-Offfline'],
                                ['route' => 'store.DOROnline', 'label' => 'R-Online'],
                                ['route' => 'store.DOHOnline', 'label' =>  'H-Online']
                                    
                                @endif
                            ];
                        @endphp --}}
                        
                        @php
                        use Illuminate\Support\Str;
                    
                        $deliveryOrders = [];
                            // if (Str::contains($salesorder->invoice_no, 'RO')) {
                            //     $deliveryOrders[] = ['route' => 'store.DOReguler', 'label' => 'R-Offline'];
                            // }
                            // if (Str::contains($salesorder->invoice_no, 'HO')) {
                            //     $deliveryOrders[] = ['route' => 'store.DOHet', 'label' => 'H-Offline'];
                            // }
                            // if (Str::contains($salesorder->invoice_no, 'RS')) {
                            //     $deliveryOrders[] = ['route' => 'store.DOROnline', 'label' => 'R-Online'];
                            // }
                            // if (Str::contains($salesorder->invoice_no, 'HS')) {
                            //     $deliveryOrders[] = ['route' => 'store.DOHOnline', 'label' => 'H-Online'];
                            // }
                            if (Str::contains($salesorder->invoice_no, ['RO', 'SOR'])) {
                                $deliveryOrders[] = ['route' => 'store.DOReguler', 'label' => 'R-Offline'];
                            }
                            if (Str::contains($salesorder->invoice_no, ['HO', 'SOH'])) {
                                $deliveryOrders[] = ['route' => 'store.DOHet', 'label' => 'H-Offline'];
                            }
                            if (Str::contains($salesorder->invoice_no, ['RS', 'SORS'])) {
                                $deliveryOrders[] = ['route' => 'store.DOROnline', 'label' => 'R-Online'];
                            }
                            if (Str::contains($salesorder->invoice_no, ['HS', 'SOHS'])) {
                                $deliveryOrders[] = ['route' => 'store.DOHOnline', 'label' => 'H-Online'];
                            }
                        @endphp

                        {{-- @foreach ($deliveryOrders as $order)
                            <form action="{{ route($order['route']) }}" method="post" class="confirmation-form">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $salesorder->id }}">
                                <button type="button" class="btn bg-success me-3 confirm-button"><b>{{ $order['label'] }}</b></button>
                            </form>
                        @endforeach --}}
                        @foreach ($deliveryOrders as $order)
                            <form action="{{ route($order['route']) }}" method="post" class="confirmation-form">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $salesorder->id }}">
                                <input type="hidden" name="shipping_status" id="shipping_status_{{ $order['route'] }}">
                                <button type="button" class="btn bg-success me-3 confirm-button" onclick="submitForm('{{ $order['route'] }}')">
                                    <b>{{ $order['label'] }}</b>
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/main.js') }}"></script>
<script>
    function submitForm(route) {
        let shippingStatus = document.querySelector("select[name='shipping_status']").value;
        if (!shippingStatus) {
            alert("Harap pilih status pengiriman terlebih dahulu!");
            return;
        }
        document.getElementById("shipping_status_" + route).value = shippingStatus;
        document.querySelector("form[action$='" + route + "']").submit();
    }
</script>

@endsection
