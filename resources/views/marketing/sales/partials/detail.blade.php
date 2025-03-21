@foreach ($sales as $salesrep)
    <div class="tab-pane fade show active" id="detail-{{ $salesrep->id }}" role="tabpanel">
        <div class="row">
            <!-- Total Customer -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-bottom mb-1">
                            <div>
                                <i class="ti ti-users"></i>
                                <h5>Total Customer</h5>
                            </div>
                            <h1 class="text-primary">{{ $salesrep->customers->count() }}</h1>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-column align-items-center text-center">
                                <span class="badge bg-success mb-1">Prioritas</span>
                                <h4 class="mb-0">{{ $salesrep->customers->where('Potensi', 'Prioritas')->count() }}</h4>
                            </div>
                            <div class="d-flex flex-column align-items-center text-center">
                                <span class="badge bg-primary mb-1">Tinggi</span>
                                <h4 class="mb-0">{{ $salesrep->customers->where('Potensi', 'Tinggi')->count() }}</h4>
                            </div>
                            <div class="d-flex flex-column align-items-center text-center">
                                <span class="badge bg-warning mb-1">Sedang</span>
                                <h4 class="mb-0">{{ $salesrep->customers->where('Potensi', 'Sedang')->count() }}</h4>
                            </div>
                            <div class="d-flex flex-column align-items-center text-center">
                                <span class="badge bg-danger mb-1">Rendah</span>
                                <h4 class="mb-0">{{ $salesrep->customers->where('Potensi', 'Rendah')->count() }}</h4>
                            </div>
                            <div class="d-flex flex-column align-items-center text-center">
                                <span class="badge bg-secondary mb-1">???</span>
                                <h4 class="mb-0">{{ $salesrep->customers->where('Potensi', '')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="mb-2 f-w-200 text-muted">Total Customer</h6>
                            <h4 class="mb-0">{{ $salesrep->customers->count() }}</h4>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-success">Prioritas</span>
                                <h4 class="mb-0">{{ $salesrep->customers->where('Potensi', 'Prioritas')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-primary">Tinggi</span>
                                <h4 class="mb-0">{{ $salesrep->customers->where('Potensi', 'Tinggi')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-warning">Sedang</span>
                                <h4 class="mb-0">{{ $salesrep->customers->where('Potensi', 'Sedang')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-danger">Rendah</span>
                                <h4 class="mb-0">{{ $salesrep->customers->where('Potensi', 'Rendah')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-danger">-</span>
                                <h4 class="mb-0">{{ $salesrep->customers->where('Potensi', '')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Transaksi -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-bottom mb-1">
                            <div>
                                <i class="ti ti-shopping-cart"></i>
                                <h5>Total Transaksi</h5>
                            </div>
                            <h1 class="text-primary">{{ $salesrep->orders->count() }}</h1>
                        </div>
                        <div id="bar-chart-1"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h3>Rekapitulasi Transaksi</h3>
                <table class="table bg-white">
                    <thead>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Subtotal</th>
                        <th>Diskon</th>
                        <th>Grand Total</th>
                        <th>Dibayarkan</th>
                        <th>Belum dibayar</th>
                    </thead>
                    <tbody>
                        <tr class="text-end">
                            <td class="text-start"><span class="badge bg-success">Selesai</span></td>
                            <td><b>{{ $salesrep->orders->where('order_status', 'Selesai')->count() }}</b></td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Selesai')->sum('sub_total')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Selesai')->sum('discount_rp')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Selesai')->sum('grandtotal')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Selesai')->sum('paid')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Selesai')->sum('due')) }}</td>
                        </tr>
                        <tr class="text-end">
                            <td class="text-start"><span class="badge bg-primary">Disetujui</span></td>
                            <td><b>{{ $salesrep->orders->where('order_status', 'Disetujui')->count() }}</b></td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Disetujui')->sum('sub_total')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Disetujui')->sum('discount_rp')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Disetujui')->sum('grandtotal')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Disetujui')->sum('paid')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Disetujui')->sum('due')) }}</td>
                        </tr>
                        <tr class="text-end">
                            <td class="text-start"><span class="badge bg-warning">Diajukan</span></td>
                            <td><b>{{ $salesrep->orders->where('order_status', 'Menunggu persetujuan')->count() }}</b></td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Menunggu persetujuan')->sum('sub_total')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Menunggu persetujuan')->sum('discount_rp')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Menunggu persetujuan')->sum('grandtotal')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Menunggu persetujuan')->sum('paid')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Menunggu persetujuan')->sum('due')) }}</td>
                        </tr>
                        <tr class="text-end">
                            <td class="text-start"><span class="badge bg-danger">Ditolak</span></td>
                            <td><b>{{ $salesrep->orders->where('order_status', 'Ditolak')->count() }}</b></td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Ditolak')->sum('sub_total')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Ditolak')->sum('discount_rp')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Ditolak')->sum('grandtotal')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Ditolak')->sum('paid')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Ditolak')->sum('due')) }}</td>
                        </tr>
                        <tr class="text-end">
                            <td class="text-start"><span class="badge bg-danger">Dibatalkan</span></td>
                            <td><b>{{ $salesrep->orders->where('order_status', 'Dibatalkan')->count() }}</b></td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Dibatalkan')->sum('sub_total')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Dibatalkan')->sum('discount_rp')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Dibatalkan')->sum('grandtotal')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Dibatalkan')->sum('paid')) }}</td>
                            <td>Rp {{ number_format($salesrep->orders->where('order_status', 'Dibatalkan')->sum('due')) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-8">
        <h5 class="mb-3">Sales Report</h5>
        <div class="card">
          <div class="card-body">
            <h6 class="mb-2 f-w-400 text-muted">This Week Statistics</h6>
            <h3 class="mb-0">$7,650</h3>
            <div id="sales-report-chart"></div>
          </div>
        </div>
      </div>
@endforeach

