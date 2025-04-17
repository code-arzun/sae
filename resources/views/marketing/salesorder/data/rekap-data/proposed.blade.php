<!-- Rekap Menunggu persetujuan -->

<div class="col-md">
    @php
        $groupedByYear = $orders->where('order_status', 'Menunggu persetujuan')->groupBy(function($order) {
            return \Carbon\Carbon::parse($order->created_at)->year;
        });
    @endphp

    @foreach($groupedByYear as $year => $ordersByYear)
        <h4 class="mt-4">{{ $year }}</h4>
        <table class="table mb-5">
            <thead class="text-white bg-dark">
                <tr>
                    <th width="100px">Bulan</th>
                    <th width="100px">Jumlah Transaksi</th>
                    <th width="100px">Total Bruto (Subtotal)</th>
                    <th width="100px">Total Diskon</th>
                    <th width="100px">Total Netto (Grandtotal)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $groupedByMonth = $ordersByYear->groupBy(function($order) {
                        return \Carbon\Carbon::parse($order->created_at)->translatedformat('F');
                    });
                @endphp

                @foreach($groupedByMonth as $month => $ordersPerMonth)
                    <tr>
                        <td><strong>{{ $month }}</strong></td>
                        <th>{{ $ordersPerMonth->count('invoice_no') }}</th>
                        <td class="accounting subtotal">{{ number_format($ordersPerMonth->sum('sub_total')) }}</td>
                        <td class="accounting discountRp">{{ number_format($ordersPerMonth->sum('discount_rp')) }}</td>
                        <td class="accounting grandtotal">{{ number_format($ordersPerMonth->sum('grandtotal')) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-cyan-100">
                <tr>
                    <th>Total</th>
                    <th>{{ $ordersByYear->count('invoice_no') }}</th>
                    <td class="accounting subtotal">{{ number_format($ordersByYear->sum('sub_total')) }}</td>
                    <td class="accounting discountRp">{{ number_format($ordersByYear->sum('discount_rp')) }}</td>
                    <td class="accounting grandtotal">{{ number_format($ordersByYear->sum('grandtotal')) }}</td>
                </tr>
            </tfoot>
        </table>
    @endforeach

    <table class="table">
        <thead class="text-white bg-dark">
            <tr>
                <th width="100px">Jumlah Transaksi</th>
                <th width="100px">Total Subtotal (Bruto)</th>
                <th width="100px">Total Diskon</th>
                <th width="100px">Total Grandtotal (Nett)</th>
            </tr>
        </thead>
        <tfoot class="bg-white">
            <tr>
                <th>{{ $orders->where('order_status', 'Menunggu persetujuan')->count('invoice_no') }}</th>
                <td class="text-center accounting subtotal">{{ number_format($orders->where('order_status', 'Menunggu persetujuan')->sum('sub_total')) }}</td>
                <td class="text-center accounting discountRp">{{ number_format($orders->where('order_status', 'Menunggu persetujuan')->sum('discount_rp')) }}</td>
                <td class="text-center accounting grandtotal">{{ number_format($orders->where('order_status', 'Menunggu persetujuan')->sum('grandtotal')) }}</td>
            </tr>
        </tfoot>
    </table>
</div>

{{-- <h4>Chart</h4>
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <form id="filterTahunForm" class="mb-3">
                <label for="tahunSelect">Filter Tahun:</label>
                <select id="tahunSelect" name="tahun" class="form-select w-auto d-inline-block">
                    <option value="">Semua Tahun</option>
                    @for ($year = now()->year; $year >= 2020; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </form>
            <canvas id="pendingTransactionChart"></canvas>
        </div>
    </div>
</div>

<script>
    document.getElementById('tahunSelect').addEventListener('change', function () {
        fetchChartData(this.value);
    });

    function fetchChartData(tahun = '') {
        fetch(`so/chart-status?tahun=${tahun}`)
            .then(response => response.json())
            .then(data => {
                const bulanLabels = [...new Set(data.map(item => item.bulan_nama))];
                // const statusSet = [...new Set(data.map(item => item.order_status))];
                const statusSet = [...new Set(data.map(item => item.order_status))].filter(status => status === 'Menunggu persetujuan');

                const colorMap = {
                    Subtotal: 'rgba(54, 162, 235, 0.8)',
                    Discount: 'rgba(255, 159, 64, 0.8)',
                    Grandtotal: 'rgba(75, 192, 192, 0.8)',
                };

                // Untuk grouped bar: gabungkan nama status + tipe nominal sebagai label unik
                const datasets = [];

                statusSet.forEach((status, statusIndex) => {
                    ['Subtotal', 'Discount', 'Grandtotal'].forEach((tipe, tipeIndex) => {
                        const dataPerBulan = bulanLabels.map(bulan => {
                            const item = data.find(d => d.bulan_nama === bulan && d.order_status === status);
                            if (!item) return 0;

                            switch (tipe) {
                                case 'Subtotal':
                                    return item.total_subtotal || 0;
                                case 'Discount':
                                    return item.total_discount || 0;
                                case 'Grandtotal':
                                    return item.total_grandtotal || 0;
                                default:
                                    return 0;
                            }
                        });

                        datasets.push({
                            label: `${tipe} - ${status}`,
                            data: dataPerBulan,
                            backgroundColor: colorMap[tipe],
                        });
                    });
                });

                function formatRupiah(angka) {
                    return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                const ctx = document.getElementById('pendingTransactionChart').getContext('2d');

                if (window.myChart) {
                    window.myChart.destroy();
                }

                window.myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: bulanLabels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return `${context.dataset.label}: ${formatRupiah(context.raw)}`;
                                    }
                                }
                            },
                            legend: {
                                position: 'bottom',
                            },
                        },
                        scales: {
                            x: {
                                stacked: false,
                                title: {
                                    display: true,
                                    text: 'Bulan'
                                },
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 0
                                }
                            },
                            y: {
                                stacked: false,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp' + value.toLocaleString('id-ID');
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Nominal Transaksi (Rp)'
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error:', error));
    }

    fetchChartData();
</script> --}}