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
    <div class="card-body row">
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Tanggal DO</span>
            <h4 class="mb-0"></h4>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Tanggal SO</span>
            <h4 class="mb-0">{{ $salesorder->order_date }}</h4>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">No. SO</span>
            <h4 class="mb-0">{{ $salesorder->invoice_no }}</h4>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Nama Lembaga</span>
            <h4 class="mb-0">{{ $salesorder->customer->NamaLembaga }}</h4>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Nama Customer</span>
            <h4 class="mb-0">{{ $salesorder->customer->NamaCustomer }}</h4>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Jabatan</span>
            <h4 class="mb-0">{{ $salesorder->customer->Jabatan }}</h4>
        </div>
        <div class="col-md d-flex flex-column">
            <span class="text-secondary mb-1">Sales</span>
            <h4 class="mb-0">{{ $salesorder->customer->employee->name }}</h4>
        </div>
    </div>
</div>

<!-- Detail Pesanan -->
@include('layout.table.confirmation-detail')

<div class="card">
    <div class="card-body d-flex justify-content-between">
        <div class="col-md-2">
            <select class="form-control @error('shipping_status') is-invalid @enderror" name="shipping_status" required>
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
            @php
                use Illuminate\Support\Str;
            
                $deliveryOrders = [];
                    if (Str::contains($salesorder->invoice_no, ['RO', 'SOR'])) {
                        $deliveryOrders[] = ['route' => 'store.DOReguler'];
                        // $deliveryOrders[] = ['route' => 'store.DOReguler', 'label' => 'R-Offline'];
                    }
                    if (Str::contains($salesorder->invoice_no, ['HO', 'SOH'])) {
                        $deliveryOrders[] = ['route' => 'store.DOHet'];
                        // $deliveryOrders[] = ['route' => 'store.DOHet', 'label' => 'H-Offline'];
                    }
                    if (Str::contains($salesorder->invoice_no, ['RS', 'SORS'])) {
                        $deliveryOrders[] = ['route' => 'store.DOROnline'];
                        // $deliveryOrders[] = ['route' => 'store.DOROnline', 'label' => 'R-Online'];
                    }
                    if (Str::contains($salesorder->invoice_no, ['HS', 'SOHS'])) {
                        $deliveryOrders[] = ['route' => 'store.DOHOnline'];
                        // $deliveryOrders[] = ['route' => 'store.DOHOnline', 'label' => 'H-Online'];
                    }
            @endphp
    
            @foreach ($deliveryOrders as $order)
                <form action="{{ route($order['route']) }}" method="post" class="confirmation-form">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $salesorder->id }}">
                    <input type="hidden" name="shipping_status" id="shipping_status_{{ $order['route'] }}">
                    <button type="submit" class="btn btn-success confirm-button" onclick="submitForm('{{ $order['route'] }}')">
                        <b>Buat Delivery Order</b>
                    </button>
                </form>
            @endforeach
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
