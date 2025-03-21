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
