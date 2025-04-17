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
                    <option value="Menunggu persetujuan">Menunggu persetujuan</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </form>
            <canvas id="SalesOrderChart"></canvas>
        </div>
    </div>
</div>

{{-- <script>
    document.querySelectorAll('#tahunSelect, #statusSelect').forEach(select => {
        select.addEventListener('change', () => {
            const tahun = document.getElementById('tahunSelect').value;
            const status = document.getElementById('statusSelect').value;
            fetchChartData(tahun, status);
        });
    });

    function fetchChartData(tahun = '', status = '') {
    fetch(`so/chart-status?tahun=${tahun}`)
        .then(response => response.json())
        .then(data => {
            const bulanLabels = [...new Set(data.map(item => item.bulan_nama))];
            const colorMap = {
                Subtotal: '#52c41a',
                Discount: '#ff4d4f',
                Grandtotal: '#1890ff',
            };

            let datasets = [];

            if (status) {
                // Filter berdasarkan status jika ada
                data = data.filter(item => item.order_status === status);

                ['Subtotal', 'Discount', 'Grandtotal'].forEach((tipe) => {
                    const dataPerBulan = bulanLabels.map(bulan => {
                        const item = data.find(d => d.bulan_nama === bulan && d.order_status === status);
                        if (!item) return 0;

                        switch (tipe) {
                            case 'Subtotal': return item.total_subtotal || 0;
                            case 'Discount': return item.total_discount || 0;
                            case 'Grandtotal': return item.total_grandtotal || 0;
                            default: return 0;
                        }
                    });

                    datasets.push({
                        label: `${tipe} - ${status}`,
                        data: dataPerBulan,
                        backgroundColor: colorMap[tipe],
                    });
                });
            } else {
                // Jika tidak difilter, tampilkan total per bulan saja (tanpa group by status)
                ['Subtotal', 'Discount', 'Grandtotal'].forEach((tipe) => {
                    const dataPerBulan = bulanLabels.map(bulan => {
                        const bulanItems = data.filter(d => d.bulan_nama === bulan);
                        let total = 0;

                        bulanItems.forEach(item => {
                            switch (tipe) {
                                case 'Subtotal': total += item.total_subtotal || 0; break;
                                case 'Discount': total += item.total_discount || 0; break;
                                case 'Grandtotal': total += item.total_grandtotal || 0; break;
                            }
                        });

                        return total;
                    });

                    datasets.push({
                        label: tipe,
                        data: dataPerBulan,
                        backgroundColor: colorMap[tipe],
                    });
                });
            }

            // Chart render
            const ctx = document.getElementById('SalesOrderChart').getContext('2d');
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
                                    return `${context.dataset.label}: Rp ${context.raw.toLocaleString('id-ID')}`;
                                }
                            }
                        },
                        legend: {
                            position: 'top',
                        },
                    },
                    scales: {
                        x: {
                            ticks: {
                                maxRotation: 45,
                                minRotation: 0
                            }
                        },
                        y: {
                            ticks: {
                                callback: function (value) {
                                    return 'Rp' + value.toLocaleString('id-ID');
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
</script> --}}
<script>
    document.querySelectorAll('#tahunSelect, #statusSelect').forEach(select => {
        select.addEventListener('change', () => {
            const tahun = document.getElementById('tahunSelect').value;
            const status = document.getElementById('statusSelect').value;
            fetchChartData(tahun, status);
        });
    });

    function fetchChartData(tahun = '', status = '') {
    fetch(`so/chart/bar?tahun=${tahun}&status=${status}`)
        .then(response => response.json())
        .then(data => {
            const bulanLabels = [...new Set(data.map(item => item.bulan_nama))];
            const datasets = [];

            const colorMap = {
                Subtotal: '#52c41a',
                Discount: '#ff4d4f',
                Grandtotal: '#1890ff'
            };

            if (!status) {
                // Data tanpa status → jumlahkan per bulan
                ['Subtotal', 'Discount', 'Grandtotal'].forEach((tipe) => {
                    const dataPerBulan = bulanLabels.map(bulan => {
                        const bulanItems = data.filter(d => d.bulan_nama === bulan);
                        return bulanItems.reduce((total, item) => {
                            switch (tipe) {
                                case 'Subtotal': return total + (item.total_subtotal || 0);
                                case 'Discount': return total + (item.total_discount || 0);
                                case 'Grandtotal': return total + (item.total_grandtotal || 0);
                                default: return total;
                            }
                        }, 0);
                    });

                    datasets.push({
                        label: tipe,
                        data: dataPerBulan,
                        backgroundColor: colorMap[tipe]
                    });
                });
            } else {
                // Data per status → tampilkan per status
                ['Subtotal', 'Discount', 'Grandtotal'].forEach((tipe) => {
                    const dataPerBulan = bulanLabels.map(bulan => {
                        const item = data.find(d => d.bulan_nama === bulan);
                        if (!item) return 0;

                        switch (tipe) {
                            case 'Subtotal': return item.total_subtotal || 0;
                            case 'Discount': return item.total_discount || 0;
                            case 'Grandtotal': return item.total_grandtotal || 0;
                            default: return 0;
                        }
                    });

                    datasets.push({
                        label: `${tipe} - ${status}`,
                        data: dataPerBulan,
                        backgroundColor: colorMap[tipe]
                    });
                });
            }

            const ctx = document.getElementById('SalesOrderChart').getContext('2d');
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
                        legend: { position: 'top' },
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