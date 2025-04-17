<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <form id="filterTahunForm" class="mb-3">
                <label for="tahunSelect">Filter Tahun:</label>
                <select id="tahunSelect" name="tahun" class="form-select w-auto d-inline-block">
                    <option value="">Semua</option>
                    @for ($year = now()->year; $year >= 2024; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            
                <label for="statusSelect" class="ms-3">Status:</label>
                <select id="statusSelect" name="status" class="form-select w-auto d-inline-block">
                    <option value="">Semua</option>
                    <option value="Siap dikirim">Siap dikirim</option>
                    <option value="Dalam Pengiriman">Dalam Pengiriman</option>
                    <option value="Terkirim">Terkirim</option>
                </select>
            </form>
            <canvas id="DeliveryOrderChart"></canvas>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('#tahunSelect, #statusSelect').forEach(select => {
        select.addEventListener('change', () => {
            const tahun = document.getElementById('tahunSelect').value;
            const status = document.getElementById('statusSelect').value;
            fetchChartData(tahun, status);
        });
    });

    function fetchChartData(tahun = '') {
    fetch(`do/chart/bar?tahun=${tahun}`)
        .then(response => response.json())
        .then(data => {
            const bulanLabels = [...new Set(data.map(item => item.bulan_nama))];
            const statusList = ['Siap dikirim', 'Dalam Pengiriman', 'Terkirim'];
            const colorMap = {
                'Siap dikirim': '#ff4d4f',
                'Dalam Pengiriman': '#faad14',
                'Terkirim': '#52c41a'
            };

            const datasets = statusList.map(status => {
                const dataPerBulan = bulanLabels.map(bulan => {
                    const match = data.find(item => item.bulan_nama === bulan && item.delivery_status === status);
                    return match ? match.total_subtotal : 0;
                });

                return {
                    label: status,
                    data: dataPerBulan,
                    backgroundColor: colorMap[status]
                };
            });

            const ctx = document.getElementById('DeliveryOrderChart').getContext('2d');
            if (window.myChart) window.myChart.destroy();

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
                                    const value = context.raw || 0;
                                    // return `${context.dataset.label}: Rp ${value.toLocaleString('id-ID')}`;
                                }
                            }
                        },
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: function (value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            },
                            title: {
                                display: true,
                                text: 'Nominal Transaksi'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error:', error));
    }

    // panggil awal dengan default
    fetchChartData();
</script>