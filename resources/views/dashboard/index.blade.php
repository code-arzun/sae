@extends('layout.main')

@section('container')
    <div class="row">
        <div class="col-lg-12">
        @if (session()->has('success'))
            <div class="alert text-white bg-success" role="alert">
                <div class="iq-alert-text">{{ session('success') }}</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
                </button>
            </div>
        @endif
        </div>
    </div>

    <!-- Hello (Pengguna) -->
    <div class="row">
        <h5 id="greetings" class="greetings"></h5>
        <h3>{{ auth()->user()->employee->name }}</h3>
    </div>

    <!-- Pic Carousel -->
    <div class="col">
        @if (auth()->user()->hasRole('Super Admin'))
        <div class="row">
            <div id="carouselExampleSlidesOnly" class="carousel slide mb-5" data-bs-ride="carousel">
                <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://images.pexels.com/photos/457882/pexels-photo-457882.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="https://images.pexels.com/photos/457882/pexels-photo-457882.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1">
                </div>
                <div class="carousel-item">
                    <img src="https://images.pexels.com/photos/620337/pexels-photo-620337.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="https://images.pexels.com/photos/620337/pexels-photo-620337.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1">
                </div>
                <div class="carousel-item">
                    <img src="..." class="d-block w-100" alt="...">
                </div>
                </div>
            </div>
        </div>
        @endif
        @if (auth()->user()->hasRole('Gudang'))
        <div class="row">
            <div id="carouselExampleSlidesOnly" class="carousel slide mb-5" data-bs-ride="carousel">
                <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://cdn.shopify.com/s/files/1/0070/7032/files/einstein.png?v=1706739683" class="d-block w-100" alt="https://cdn.shopify.com/s/files/1/0070/7032/files/einstein.png?v=1706739683">
                </div>
                <div class="carousel-item">
                    <img src="https://images.pexels.com/photos/620337/pexels-photo-620337.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="https://images.pexels.com/photos/620337/pexels-photo-620337.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1">
                </div>
                <div class="carousel-item">
                    <img src="..." class="d-block w-100" alt="...">
                </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    
@endsection

@if ((!isset($attendance) || $attendance->status == null)
    && (Carbon\Carbon::now()->format('H:i') >= '07:00'
    && Carbon\Carbon::now()->format('H:i') <= '16:00'
    ))
@include('attendance.checkin')
@endif

@section('specificpagescripts')
<!-- Table Treeview JavaScript -->
{{-- <script src="{{ asset('assets/js/table-treeview.js') }}"></script>
<!-- Chart Custom JavaScript -->
<script src="{{ asset('assets/js/customizer.js') }}"></script>
<!-- Chart Custom JavaScript -->
<script async src="{{ asset('assets/js/chart-custom.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/app.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/main.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/dashboard.js') }}"></script> --}}

@endsection
