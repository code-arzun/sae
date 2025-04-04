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
    <div class="row mb-3">
        <h5 id="greetings" class="greetings"></h5>
        <h3>{{ auth()->user()->employee->name }}</h3>
    </div>

    <!-- Pic Carousel -->
    {{-- <div class="col">
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
    </div> --}}

    <div class="row">
        <!-- Super Admin -->
        @if (auth()->user()->hasRole('Super Admin'))
            @include('marketing.salesorder.data.rekap-data.all')
        <!-- Sales -->
        @elseif (auth()->user()->hasRole('Sales'))
            @include('marketing.salesorder.data.rekap-data.all')
        <!-- Admin -->
        @elseif (auth()->user()->hasRole('Admin'))
            @include('marketing.salesorder.data.rekap-data.all')
        <!-- Gudang -->
        @elseif (auth()->user()->hasRole('Admin Gudang'))
        <div class="row">
            <div id="carouselExampleSlidesOnly" class="carousel slide mb-5" data-bs-ride="carousel">
                <div class="carousel-inner">
                <div class="carousel-item active">
                    {{-- <img src="https://images.unsplash.com/photo-1627309366653-2dedc084cdf1?q=80&w=1966&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100" alt=""> --}}
                    <img src="https://images.pexels.com/photos/4483610/pexels-photo-4483610.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1624927637280-f033784c1279?q=80&w=2074&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100" alt="...">
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

@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Greetings
    const greetingElement = document.getElementById('greetings');
    if (greetingElement) {
        const now = new Date();
        const currentHour = now.getHours();
        let greetingMessage = '';

        if (currentHour >= 0 && currentHour <= 10) {
            greetingMessage = 'Pagi';
        } else if (currentHour >= 11 && currentHour <= 14) {
            greetingMessage = 'Siang';
        } else if (currentHour >= 14 && currentHour <= 18) {
            greetingMessage = 'Sore';
        } else if (currentHour >= 18 && currentHour <= 23) {
            greetingMessage = 'Malam';
        }

        greetingElement.textContent = `Selamat ${greetingMessage}, ${greetingElement.textContent}`;
    }

    // Popup Absensi
    const attendanceModalElement = document.getElementById('attendanceCheckinModal');
    const currentDate = new Date();
    const currentDay = currentDate.getDay(); // Mengambil hari dalam seminggu

    if (attendanceModalElement && currentDay !== 0) { // 0 berarti hari Minggu
        const attendanceModal = new bootstrap.Modal(attendanceModalElement, {
            keyboard: false,
            backdrop: 'static',
        });
        attendanceModal.show();
    }

    const hadirRadio = document.getElementById('hadir');
    const tidakHadirRadio = document.getElementById('tidak_hadir');
    const timepickerDiv = document.getElementById('timepickerDiv');
    const keteranganDiv = document.getElementById('keteranganDiv');

    if (hadirRadio && tidakHadirRadio) {
        hadirRadio.addEventListener('change', function () {
            if (this.checked) {
                timepickerDiv.style.display = 'block';
                document.getElementById('datangTime').setAttribute('required', 'required');
                keteranganDiv.style.display = 'none';
                document.getElementById('keterangan').removeAttribute('required');
            }
        });

        tidakHadirRadio.addEventListener('change', function () {
            if (this.checked) {
                timepickerDiv.style.display = 'none';
                document.getElementById('datangTime').removeAttribute('required');
                keteranganDiv.style.display = 'block';
                document.getElementById('keterangan').setAttribute('required', 'required');
            }
        });
    }

    // Chart
    fetch('/orders/chart-status')
        .then(response => response.json())
        .then(data => {
            console.log("Data dari server:", data); // Debugging

            // Filter data based on user sales
            const userSalesData = data.filter(order => order.user_sales === 'specificUser'); // Replace 'specificUser' with the actual user identifier

            const labels = userSalesData.map(order => order.order_status);
            const orderCounts = userSalesData.map(order => order.total_orders);
            const subTotals = userSalesData.map(order => order.total_sub_total);
            const discounts = userSalesData.map(order => order.total_discount);
            const grandTotals = userSalesData.map(order => order.total_grandtotal);

            function formatRupiah(angka) {
                return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }


            // Chart Jumlah Order per Status
            const ctx1 = document.getElementById('orderStatusChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Order',
                        data: orderCounts,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `${context.dataset.label}: ${context.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Chart Subtotal, Discount, dan Grandtotal dengan Format Rupiah
            const ctx2 = document.getElementById('orderTotalChart').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Sub Total',
                            data: subTotals,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Discount',
                            data: discounts,
                            backgroundColor: 'rgba(255, 206, 86, 0.6)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Grand Total',
                            data: grandTotals,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `${context.dataset.label}: ${formatRupiah(context.raw)}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

        })
        .catch(error => console.error('Error:', error));
    });
</script>