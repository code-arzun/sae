@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('retur.index') }}">Retur</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('input.retur') }}">Input</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('inputretur.confirmation') }}">Konfirmarsi</a></li>
@endsection

@section('container')

<div class="card">
    <div class="card-body row">
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Tanggal DO</span>
            <h5 class="mb-0">{{ $deliveryorder->delivery_date }}</h5>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Tanggal SO</span>
            <h5 class="mb-0">{{ $deliveryorder->salesorder->order_date }}</h5>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">No. SO</span>
            <h5 class="mb-0">{{ $deliveryorder->salesorder->invoice_no }}</h5>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Nama Lembaga</span>
            <h5 class="mb-0">{{ $deliveryorder->salesorder->customer->NamaLembaga }}</h5>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Nama Customer</span>
            <h5 class="mb-0">{{ $deliveryorder->salesorder->customer->NamaCustomer }}</h5>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Jabatan</span>
            <h5 class="mb-0">{{ $deliveryorder->salesorder->customer->Jabatan }}</h5>
        </div>
        <div class="col-md d-flex flex-column">
            <span class="text-secondary mb-1">Sales</span>
            <h5 class="mb-0">{{ $deliveryorder->salesorder->customer->employee->name }}</h5>
        </div>
    </div>
</div>

<!-- Detail Pesanan -->
@include('layout.table.confirmation-detail')

<div class="offset-lg-8">
    <table class="table text-end">
        <tr>
            <th>Total Item</th>
            <th><span class="badge bg-secondary w-100"> {{ number_format(count(Cart::content())) }}</span></th>
            <th>Total Barang</th>
            <th><span class="badge bg-secondary w-100"> {{ number_format(Cart::count()) }}</span></th>
            <th>Subtotal</th>
            <th class="accounting subtotal">{{ number_format(Cart::subtotal()) }}</th>
        </tr>
        <tr>
            <th colspan="4">Diskon</th>
            <th class="accounting discountPercent">{{ number_format($discount_percent) }}</th>
            <th class="accounting discountRp">{{ number_format($discount_rp) }}</th>
        </tr>
        <tr>
            <th colspan="5">Grand Total</th>
            <th class="accounting grandtotal">{{ number_format($grandtotal) }}</th>
        </tr>
    </table>
</div>

<div class="card">
    <div class="card-body d-flex justify-content-between">
        <h5 class="text-danger">* Pastikan data yang Anda masukkan sudah sesuai! *</h5>
        <div class="invoice-btn d-flex" data-extra-toggle="confirmation">
            @php
                use Illuminate\Support\Str;
            
                $returOrders = [];
                    if (Str::contains($deliveryorder->salesorder->invoice_no, ['RO', 'DOR'])) {
                        $returOrders[] = ['route' => 'store.ROReguler'];
                    }
                    if (Str::contains($deliveryorder->salesorder->invoice_no, ['HO', 'DOH'])) {
                        $returOrders[] = ['route' => 'store.ROHet'];
                    }
                    if (Str::contains($deliveryorder->salesorder->invoice_no, ['RS', 'DORS'])) {
                        $returOrders[] = ['route' => 'store.ROROnline'];
                    }
                    if (Str::contains($deliveryorder->salesorder->invoice_no, ['HS', 'DOHS'])) {
                        $returOrders[] = ['route' => 'store.ROHOnline'];
                    }
            @endphp
    
            @foreach ($returOrders as $retur)
                <form action="{{ route($retur['route']) }}" method="post" class="confirmation-form">
                    @csrf
                    <input type="hidden" name="delivery_id" value="{{ $deliveryorder->id }}">
                    <input type="hidden" name="discount_percent" value="{{ $discount_percent }}">
                    <input type="hidden" name="discount_rp" value="{{ $discount_rp }}">
                    <input type="hidden" name="grandtotal" value="{{ $grandtotal }}">
                    <button type="submit" class="btn btn-success confirm-button" onclick="submitForm('{{ $retur['route'] }}')">
                        <b>Buat Retur</b>
                    </button>
                </form>
            @endforeach
        </div>
    </div>
</div>

@endsection
