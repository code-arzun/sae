<!-- Rekap Menunggu persetujuan -->
<div class="col-md-2">
    <div class="card">
        <div class="card-body d-flex justify-content-between">
            <div>
                <h5>Total Transaksi</h5>
                <span class="badge bg-warning">Menunggu Persetujuan</span>
            </div>
            <div>
                <h1 class="text-warning">{{ $orders->where('order_status', 'Menunggu persetujuan')->count('invoice_no') }}</h1>
            </div>
        </div>
    </div>
</div>
<div class="col-md-10">
    <table class="table bg-white">
        <thead class="text-center text-white">
            <tr>
                <th>Total Subtotal (Bruto)</th>
                <th>Total Diskon</th>
                <th>Total Grandtotal (Nett)</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr>
                <td>
                    <span class="badge bg-success text-white">
                    Rp {{ number_format($orders->where('order_status', 'Menunggu persetujuan')->sum('sub_total')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-danger text-white">
                    Rp {{ number_format($orders->where('order_status', 'Menunggu persetujuan')->sum('discount_rp')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-primary text-white">
                    Rp {{ number_format($orders->where('order_status', 'Menunggu persetujuan')->sum('grandtotal')) }}
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>