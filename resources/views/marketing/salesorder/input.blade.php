@extends('layout.main')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

@section('container')

<div class="row">
    <div class="d-flex justify-content-between mb-3">
        <div>
            <h2>{{ $title }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-default-icon">
                    @include('marketing.salesorder.partials.breadcrumb')
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('input.so') }}">Input</a></li>
                </ol>
            </nav>
        </div>
    </div>
    
    <!-- Produk -->
    <div class="col-lg-5 col-md-12">
        @include('marketing.salesorder.input.product')
    </div>
    
    <!-- Cart -->
    <div class="col-lg-7 col-md-12">
        @include('marketing.salesorder.input.cart')
    </div>

@include('components.preview-img-form')

@endsection

<script>
    $(document).ready(function () {
        if ($.fn.select2 === undefined) {
            console.error("Select2 tidak dimuat! Periksa apakah script Select2 sudah di-load.");
            return;
        }

        $('#customer_id').select2({
            templateResult: formatOption,
            templateSelection: formatOptionSelection
        });

        function formatOption(option) {
            if (!option.id) {
                return option.text;
            }

            let namaLembaga = $(option.element).data('nama-lembaga') || '';
            let namaCustomer = $(option.element).data('nama-customer') || '';
            let jabatan = $(option.element).data('jabatan') || '';
            let employeeName = $(option.element).data('employee-name') || '';

            let content = $(`
                <div class="select2-table-row">
                    <div class="select2-table-cell">${namaLembaga}</div>
                    <div class="select2-table-cell">${namaCustomer}</div>
                    <div class="select2-table-cell">${jabatan}</div>
                    ${employeeName ? `<div class="select2-table-cell">${employeeName}</div>` : ''}
                </div>
            `);

            return content;
        }

        function formatOptionSelection(option) {
            return option.text;
        }
    });
</script>