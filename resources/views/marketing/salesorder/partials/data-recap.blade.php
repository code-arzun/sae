<ul class="nav nav-pills mb-3" id="transaction" role="tablist">
    <li class="nav-item me-3">
        <a class="nav-link active" id="pills-total-tab" data-bs-toggle="pill" href="#pills-total" role="tab" aria-controls="pills-total" aria-selected="true">Total Transaksi</a>
    </li>
    <li class="nav-item me-3">
        <a class="nav-link" id="pills-finished-tab" data-bs-toggle="pill" href="#pills-finished" role="tab" aria-controls="pills-finished" aria-selected="false">Selesai</a>
    </li>
    <li class="nav-item me-3">
        <a class="nav-link" id="pills-approved-tab" data-bs-toggle="pill" href="#pills-approved" role="tab" aria-controls="pills-approved" aria-selected="false">Disetujui</a>
    </li>
    <li class="nav-item me-3">
        <a class="nav-link" id="pills-proposed-tab" data-bs-toggle="pill" href="#pills-proposed" role="tab" aria-controls="pills-proposed" aria-selected="false">Menunggu Persetujuan</a>
    </li>
    <li class="nav-item me-3">
        <a class="nav-link" id="pills-declined-tab" data-bs-toggle="pill" href="#pills-declined" role="tab" aria-controls="pills-declined" aria-selected="false">Ditolak</a>
    </li>
    <li class="nav-item me-3">
        <a class="nav-link" id="pills-cancelled-tab" data-bs-toggle="pill" href="#pills-cancelled" role="tab" aria-controls="pills-cancelled" aria-selected="false">Dibatalkan</a>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
    <!-- Rekap Total -->
    <div class="tab-pane fade show active" id="pills-total" role="tabpanel" aria-labelledby="pills-total-tab">
        <div class="row">
            @include('marketing.salesorder.partials.rekap-data.all')
        </div>
    </div>
    <!-- Rekap Selesai -->
    <div class="tab-pane fade" id="pills-finished" role="tabpanel" aria-labelledby="pills-finished-tab">
        <div class="row">
            @include('marketing.salesorder.partials.rekap-data.finished')
        </div>
    </div>
    <!-- Rekap Disetujui -->
    <div class="tab-pane fade" id="pills-approved" role="tabpanel" aria-labelledby="pills-approved-tab">
        <div class="row">
            @include('marketing.salesorder.partials.rekap-data.approved')
        </div>
    </div>
    <!-- Rekap Menunggu Persetujuan -->
    <div class="tab-pane fade" id="pills-proposed" role="tabpanel" aria-labelledby="pills-proposed-tab">
        <div class="row">
            @include('marketing.salesorder.partials.rekap-data.proposed')
        </div>
    </div>
    <!-- Rekap Ditolak -->
    <div class="tab-pane fade" id="pills-declined" role="tabpanel" aria-labelledby="pills-declined-tab">
        <div class="row">
            @include('marketing.salesorder.partials.rekap-data.declined')
        </div>
    </div>
    <!-- Rekap Dibatalkan -->
    <div class="tab-pane fade" id="pills-cancelled" role="tabpanel" aria-labelledby="pills-cancelled-tab">
        <div class="row">
            @include('marketing.salesorder.partials.rekap-data.cancelled')
        </div>
    </div>
</div>

<script>
// import Chart from 'chart.js/auto';

document.addEventListener("DOMContentLoaded", function () {
    fetch('/orders/chart-status')
        .then(response => response.json())
        .then(data => {
            console.log("Data dari server:", data); // Debugging

            const labels = data.map(order => order.order_status);
            const orderCounts = data.map(order => order.total_orders);
            const subTotals = data.map(order => order.total_sub_total);
            const discounts = data.map(order => order.total_discount);
            const grandTotals = data.map(order => order.total_grandtotal);

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