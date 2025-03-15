@foreach ($sales as $salerep)
    <div class="tab-pane fade" id="detail-{{ $salerep->id }}" role="tabpanel">
        <div class="row">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="mb-2 f-w-200 text-muted">Total Customer</h6>
                            <h4 class="mb-0">{{ $salerep->customers->count() }}</h4>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-success">Prioritas</span>
                                <h4 class="mb-0">{{ $salerep->customers->where('Potensi', 'Prioritas')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-primary">Tinggi</span>
                                <h4 class="mb-0">{{ $salerep->customers->where('Potensi', 'Tinggi')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-warning">Sedang</span>
                                <h4 class="mb-0">{{ $salerep->customers->where('Potensi', 'Sedang')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-danger">Rendah</span>
                                <h4 class="mb-0">{{ $salerep->customers->where('Potensi', 'Rendah')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-danger">-</span>
                                <h4 class="mb-0">{{ $salerep->customers->where('Potensi', '')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="mb-2 f-w-200 text-muted">Total Customer</h6>
                            <h4 class="mb-0">{{ $salerep->customers->count() }}</h4>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-success">Prioritas</span>
                                <h4 class="mb-0">{{ $salerep->customers->where('Potensi', 'Prioritas')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-primary">Tinggi</span>
                                <h4 class="mb-0">{{ $salerep->customers->where('Potensi', 'Tinggi')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-warning">Sedang</span>
                                <h4 class="mb-0">{{ $salerep->customers->where('Potensi', 'Sedang')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-danger">Rendah</span>
                                <h4 class="mb-0">{{ $salerep->customers->where('Potensi', 'Rendah')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-danger">-</span>
                                <h4 class="mb-0">{{ $salerep->customers->where('Potensi', '')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="mb-2 f-w-200 text-muted">Total Transaksi</h6>
                            <h4 class="mb-0">{{ $salerep->orders->count() }}</h4>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-success">Selesai</span>
                                <h4 class="mb-0">{{ $salerep->orders->where('order_status', 'Selesai')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-primary">Disetujui</span>
                                <h4 class="mb-0">{{ $salerep->orders->where('order_status', 'Disetujui')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-warning">Diajukan</span>
                                <h4 class="mb-0">{{ $salerep->orders->where('order_status', 'Menunggu persetujuan')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-danger">Ditolak</span>
                                <h4 class="mb-0">{{ $salerep->orders->where('order_status', 'Ditolak')->count() }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-danger">Dibatalkan</span>
                                <h4 class="mb-0">{{ $salerep->orders->where('order_status', 'Dibatalkan')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                    <table class="table">
                        <thead class="text-center">
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
                                <td><span class="badge bg-success">Selesai</span></td>
                                <td><h4 class="mb-0">{{ $salerep->orders->where('order_status', 'Selesai')->count() }}</h4></td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Selesai')->sum('sub_total')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Selesai')->sum('discount_rp')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Selesai')->sum('grandtotal')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Selesai')->sum('paid')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Selesai')->sum('due')) }}</td>
                            </tr>
                            <tr class="text-end">
                                <td><span class="badge bg-primary">Disetujui</span></td>
                                <td><h4 class="mb-0">{{ $salerep->orders->where('order_status', 'Disetujui')->count() }}</h4></td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Disetujui')->sum('sub_total')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Disetujui')->sum('discount_rp')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Disetujui')->sum('grandtotal')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Disetujui')->sum('paid')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Disetujui')->sum('due')) }}</td>
                            </tr>
                            <tr class="text-end">
                                <td><span class="badge bg-warning">Diajukan</span></td>
                                <td><h4 class="mb-0">{{ $salerep->orders->where('order_status', 'Menunggu persetujuan')->count() }}</h4></td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Menunggu persetujuan')->sum('sub_total')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Menunggu persetujuan')->sum('discount_rp')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Menunggu persetujuan')->sum('grandtotal')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Menunggu persetujuan')->sum('paid')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Menunggu persetujuan')->sum('due')) }}</td>
                            </tr>
                            <tr class="text-end">
                                <td><span class="badge bg-danger">Ditolak</span></td>
                                <td><h4 class="mb-0">{{ $salerep->orders->where('order_status', 'Ditolak')->count() }}</h4></td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Ditolak')->sum('sub_total')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Ditolak')->sum('discount_rp')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Ditolak')->sum('grandtotal')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Ditolak')->sum('paid')) }}</td>
                                <td>Rp {{ number_format($salerep->orders->where('order_status', 'Ditolak')->sum('due')) }}</td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
@endforeach

<!-- Apex Chart -->
<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>