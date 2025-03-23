@extends('layout.main')

@section('specificpagestyles')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('container')

<div class="d-flex justify-content-between mb-3">
    <div>
        <h2>{{ $title }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-default-icon">
                @include('warehouse.delivery.partials.breadcrumb')
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('input.do') }}">Input</a></li>
            </ol>
        </nav>
    </div>
    <div>

    </div>
</div>

<div class="row" hidden>
    <form action="#" method="get">
    <!-- Filter berdasarkan SO -->
    <div class="col-sm-12 mb-3">
        <select class="form-control order_id" name="order_id"
            data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan SO" onchange="this.form.submit()">
            <option selected="" disabled="">-- Pilih SO --</option>
            <option value="" @if(request('order_id') == 'null') selected="selected" @endif>Semua</option>
            @foreach ($salesorders as $salesorder)
                <option value="{{ $salesorder->id }}" {{ request('order_id') == $salesorder->id ? 'selected' : '' }}>
                    {{ $salesorder->invoice_no }} | {{ $salesorder->customer->NamaLembaga }} - 
                    {{ $salesorder->customer->NamaCustomer }} | Rp {{ number_format($salesorder->sub_total) }} | {{ $salesorder->customer->employee->name }}
                </option>
            @endforeach
        </select>
    </div>
    </form>
</div>
<!-- Sales Order -->
<div class="card">
    <div class="card-body d-flex justify-content-between">
        <div class="d-flex flex-column align-items-center text-center">
            <label class="text-secondary mb-2">Tanggal Pemesanan</label>
            <h4>{{ $salesorder->order_date }}</h4>
        </div>
        <div class="d-flex flex-column align-items-center text-center">
            <label class="text-secondary mb-2">No. SO</label>
            <span class="badge 
                {{ // $salesorder->order_status === 'Menunggu persetujuan' ? 'bg-purple' : 
                    (strpos($salesorder->invoice_no, '-RO') !== false ? 'bg-primary' : 
                    (strpos($salesorder->invoice_no, '-HO') !== false ? 'bg-danger' : 
                    (strpos($salesorder->invoice_no, '-RS') !== false ? 'bg-success' : 
                    (strpos($salesorder->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary')))) }}">
                    {{ $salesorder->invoice_no }}
            </span>
        </div>
        <div class="d-flex flex-column align-items-center text-center">
            <label class="text-secondary mb-2">Nama Lembaga</label>
            <h4>{{ $salesorder->customer->NamaLembaga }}</h4>
        </div>
        <div class="d-flex flex-column align-items-center text-center">
            <label class="text-secondary mb-2">Nama Customer</label>
            <h4>{{ $salesorder->customer->NamaCustomer }}</h4>
        </div>
        <div class="d-flex flex-column align-items-center text-center">
            <label class="text-secondary mb-2">Sales</label>
            <h4>{{ explode(' ', $salesorder->customer->employee->name)[0] }}</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-12">
    <!-- Produk -->
        @include('warehouse.delivery.input.product')
    </div>
    
    <!-- Cart -->
    <div class="col-lg-6 col-md-12 mb-5">
        @include('warehouse.delivery.input.cart')
    </div>
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
