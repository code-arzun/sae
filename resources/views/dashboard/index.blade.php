@extends('layout.main')

@section('container')

<!-- Greetings -->
    <div class="row mb-3">
        <h5 id="greetings" class="greetings"></h5>
        <h3>{{ auth()->user()->employee->name }}</h3>
    </div>
<!-- Greetings end -->

<!-- Rekap -->
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
<!-- Rekap end -->
    
@endsection


<!-- Attendance Pop-up -->
@if ((!isset($attendance) || $attendance->status == null) 
    && (Carbon\Carbon::now()->format('H:i') >= '06:00' // Start of the Day
    && Carbon\Carbon::now()->format('H:i') <= '17:00' // End of the Day
    && Carbon\Carbon::now()->format('l') != 'Sunday' // Not Sunday
    ))
    @include('attendance.checkin')
@endif

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

    // Attendance Pop-up
        const attendanceModalElement = document.getElementById('attendanceCheckinModal');
        const currentDate = new Date();
        const currentDay = currentDate.getDay(); // 0 = Minggu

        function updateClock() {
            const now = new Date();
            const jam = String(now.getHours()).padStart(2, '0');
            const menit = String(now.getMinutes()).padStart(2, '0');
            const detik = String(now.getSeconds()).padStart(2, '0');
            const clockEl = document.getElementById('clock');
            if (clockEl) {
                clockEl.textContent = `${jam}:${menit}:${detik}`;
            }
        }

        setInterval(updateClock, 1000);
        updateClock();

        if (attendanceModalElement && currentDay !== 0) {
            const attendanceModal = new bootstrap.Modal(attendanceModalElement, {
                keyboard: false,
                backdrop: 'static',
            });
            attendanceModal.show();
        }

        const hadirRadio = document.getElementById('hadir');
        const tidakHadirRadio = document.getElementById('tidak_hadir');
        const keteranganDiv = document.getElementById('keteranganDiv');
        const hadirLabel = document.querySelector("label[for='hadir']");
        const tidakHadirLabel = document.querySelector("label[for='tidak_hadir']");

        if (hadirRadio && tidakHadirRadio) {
            hadirRadio.addEventListener('change', function () {
                if (this.checked) {
                    hadirLabel.classList.add('active');
                    tidakHadirLabel.classList.remove('active');
                    if (keteranganDiv) {
                        keteranganDiv.style.display = 'none';
                        document.getElementById('keterangan').removeAttribute('required');
                    }
                }
            });

            tidakHadirRadio.addEventListener('change', function () {
                if (this.checked) {
                    tidakHadirLabel.classList.add('active');
                    hadirLabel.classList.remove('active');
                    if (keteranganDiv) {
                        keteranganDiv.style.display = 'block';
                        document.getElementById('keterangan').setAttribute('required', 'required');
                    }
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