@extends('layout.main')

@section('container')

<div class="d-flex justify-content-between mb-3">
    <div>
        <h2>{{ $title }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-default-icon">
                @include('warehouse.delivery.partials.breadcrumb')
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('input.do') }}">Input</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('inputdo.confirmation') }}">Konfirmasi</a></li>
            </ol>
        </nav>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">Tgl. SO</span>
                <h4 class="mb-0">{{ $salesorder->order_date }}</h4>
            </div>
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">No. SO</span>
                <span class="badge me-2
                    {{ // $salesorder->order_status === 'Menunggu persetujuan' ? 'bg-purple' : 
                        (strpos($salesorder->invoice_no, '-RO') !== false ? 'bg-primary' : 
                        (strpos($salesorder->invoice_no, '-HO') !== false ? 'bg-danger' : 
                        (strpos($salesorder->invoice_no, '-RS') !== false ? 'bg-success' : 
                        (strpos($salesorder->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary')))) }}">
                        {{ $salesorder->invoice_no }}
                </span>                
            </div>
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">Nama Lembaga</span>
                <h4 class="mb-0">{{ $salesorder->customer->NamaLembaga }}</h4>
            </div>
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">Nama Customer</span>
                <h4 class="mb-0">{{ $salesorder->customer->NamaCustomer }}</h4>
            </div>
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">Jabatan</span>
                <h4 class="mb-0">{{ $salesorder->customer->Jabatan }}</h4>
            </div>
            <div class="d-flex flex-column align-items-start">
                <span class="text-secondary mb-1">Sales</span>
                <h4 class="mb-0">{{ $salesorder->customer->employee->name }}</h4>
            </div>
        </div>
       
        <!-- Detail Pesanan -->
        <table class="table table-striped nowrap">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th width="250px">Kategori</th>
                    <th width="150px">Harga</th>
                    <th width="150px">Jumlah</th>
                    <th width="150px">Total</th>
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
        <div class="d-flex justify-content-between">
            <div class="form-group col-md-4">
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
            <div class="col-md-6">
                <table class="table text-end">
                    <tr>
                        <th>Total Item</th>
                        <th><span class="badge bg-secondary w-100"> {{ number_format(count(Cart::content())) }}</span></th>
                        <th>Total Barang</th>
                        <th><span class="badge bg-secondary w-100"> {{ number_format(Cart::count()) }}</span></th>
                        <th>Subtotal</th>
                        <th><span class="badge bg-success w-100">Rp {{ number_format(Cart::subtotal()) }}</span></th>
                    </tr>
                </table>
            </div>
        </div>
        
    </div>
</div>
<span class="badge bg-danger w-100 mb-3">Pastikan data yang Anda masukkan sudah benar!</span>
            <div class="d-flex justify-content-between" data-extra-toggle="confirmation">
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
                        <input type="" name="order_id" value="{{ $salesorder->id }}">
                        <input type="" name="shipping_status" id="shipping_status_{{ $order['route'] }}">
                        <button type="submit" class="btn bg-success me-3 confirm-button" onclick="submitForm('{{ $order['route'] }}')">
                            <b>{{ $order['label'] }}</b>
                        </button>
                    </form>
                @endforeach

{{-- <div class="col"> --}}
    {{-- <a href="#" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#saveDO"> --}}
        {{-- Simpan --}}
    {{-- </a> --}}
    {{-- @include('warehouse.delivery.input.save') --}}
{{-- </div> --}}

@endsection

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
