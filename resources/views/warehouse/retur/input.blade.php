@extends('layout.main')

@section('specificpagestyles')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('retur.index') }}">Retur</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('input.retur') }}">Input</a></li>
@endsection

@section('container')
<div class="row">
    <div class="col-sm-12 mb-3">
        <select class="form-control delivery_id" name="delivery_id"
            data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan SO" onchange="this.form.submit()" disabled>
            <option selected="" disabled="">-- Pilih DO --</option>
            <option value="" @if(request('delivery_id') == 'null') selected="selected" @endif>Semua</option>
            @foreach ($deliveryOrders as $deliveryOrder)
            <option value="{{ $deliveryOrder->id }}" {{ request('delivery_id') == $deliveryOrder->id ? 'selected' : '' }}>
                {{ $deliveryOrder->invoice_no }} | {{ $deliveryOrder->salesorder->customer->NamaLembaga }} - 
                {{ $deliveryOrder->salesorder->customer->NamaCustomer }} | Rp {{ number_format($deliveryOrder->sub_total) }} | {{ $deliveryOrder->salesorder->customer->employee->name }}
            </option>
            @endforeach
        </select>
    </div>
    <!-- Produk -->
    <div class="col-lg-5 col-md-12">
        @include('warehouse.retur.input.product')
    </div>

    <!-- Cart -->
    <div class="col-lg-7 col-md-12">
        @include('warehouse.retur.input.cart')
    </div>
    {{-- <div class="col-lg-7 col-md-12">
        <table class="table">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Nama Produk</th>
                    <th width="5px">Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productItem as $item)
                <tr>
                    <td class="text-center">
                        <a href="{{ route('inputretur.deleteCart', $item->rowId) }}" class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="fa-solid fa-trash me-0"></i></a>
                    </td>
                    <td><b>{{ $item->name }}</b>
                        <p>{{ $item->category }}</p>
                    </td>
                    <td style="min-width: 140px;">
                        <form action="{{ route('inputretur.updateCart', $item->rowId) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="number" class="form-control text-center" name="qty" required
                                    value="{{ old('qty', $item->qty) }}" onblur="this.form.submit()">
                            </div>
                        </form>
                    </td>
                    <td class="text-end">Rp {{ number_format($item->price) }}</td>
                    <td class="text-end">Rp {{ number_format($item->subtotal) }}</td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Total -->
        <table class="table table-striped table-bordered nowrap">
            <thead >
                <tr class="text-end">
                    <th>Total Item<span class="badge bg-secondary ml-3">{{ number_format(count(Cart::content())) }}</span></th>
                    <th>Total Barang<span class="badge bg-primary ml-3">{{ number_format(Cart::count()) }}</span></th>
                    <th>Subtotal<span class="badge bg-success ml-3">Rp {{ number_format(Cart::subtotal()) }}</span>  
                        <span id="subtotal" hidden>{{ Cart::subtotal() }}</span>
                    </th>
                </tr>
            </thead>
            <!-- Diskon -->
            <tbody>
                <form action="{{ route('inputretur.confirmation') }}" method="POST">
                    @csrf
                    <tr>
                        <th class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Gunakan titik (.) sebagai pemisah!">Diskon (%)</th>
                        <th>
                            <div class="input-group">
                                <input type="number" step="0.01" data-bs-toggle="tooltip" data-bs-placement="top" title="Gunakan titik (.) sebagai pemisah!"
                                    onclick="calculateDiscount()" onkeyup="calculateDiscount()" class="form-control text-center"
                                    id="discount_percent" name="discount_percent" value="{{ old('discount_percent', 0) }}">
                            </div>
                        </th>
                        <th>
                            <input type="number" class="form-control text-center bg-white" id="discount_rp" name="discount_rp" value="{{ old('discount_rp', 0) }}" readonly>
                        </th>
                    </tr>
            </tbody>
            <!-- Grand Total -->
            <tfoot >
                <tr>
                    <th colspan="2" class="text-end">Grand Total</th>
                    <th>
                        <input type="number" class="form-control bg-white text-center" id="grandtotal" name="grandtotal" value="{{ old('grandtotal', 0) }}" readonly>
                    </th>
                    
                </tr>
            </tfoot>
        </table>

        <form action="{{ route('inputretur.confirmation') }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-md" hidden>
                    <label for="delivery_id">Delivery Order</label>
                    <select class="form-control delivery_id bg-white" name="delivery_id" id="delivery_id">
                        <option selected="" disabled="">-- Pilih DO --</option>
                        <option value="" @if(request('delivery_id') == 'null') selected="selected" @endif>Semua</option>
                        @foreach ($deliveryOrders as $deliveryOrder)
                        <option value="{{ $deliveryOrder->id }}" {{ request('delivery_id') == $deliveryOrder->id ? 'selected' : '' }}>
                            {{ $deliveryOrder->invoice_no }} | {{ $deliveryOrder->salesorder->customer->NamaLembaga }} - 
                            {{ $deliveryOrder->salesorder->customer->NamaCustomer }} | Rp {{ number_format($deliveryOrder->sub_total) }} | {{ $deliveryOrder->salesorder->customer->employee->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('delivery_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-success w-100"><b>Buat Retur</b></button>
                </div>
            </div>
        </form>
    </div> --}}
</div>

<script>
    $('#order_date').datepicker({
        uiLibrary: 'bootstrap4',
        // format: 'dd-mm-yyyy'
        format: 'yyyy-mm-dd'
        // https://gijgo.com/datetimepicker/configuration/format
    });
</script>

{{-- @include('components.preview-img-form') --}}
@endsection
