<!-- Rekap Disetujui -->
<div class="col-md-2">
    <div class="card">
        <div class="card-body d-flex justify-content-between">
            <div>
                <h5>Total Transaksi</h5>
                <span class="badge bg-primary">Disetujui</span>
            </div>
            <div>
                <h1 class="text-primary">{{ $orders->where('order_status', 'Disetujui')->count('invoice_no') }}</h1>
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
                <th>Total Telah dibayar</th>
                <th>Total Diskon</th>
                <th>Total Biaya-biaya & Diskon</th>
                <th>Total Diterima</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr>
                <td>
                    <span class="badge bg-success text-white">
                    Rp {{ number_format($orders->where('order_status', 'Disetujui')->sum('sub_total')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-danger text-white">
                    Rp {{ number_format($orders->where('order_status', 'Disetujui')->sum('discount_rp')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-success text-white">
                    Rp {{ number_format($orders->where('order_status', 'Disetujui')->sum('grandtotal')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-success text-white">
                    Rp {{ number_format($orders->where('order_status', 'Disetujui')->sum('pay')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-warning text-white">
                    Rp {{ number_format($collections->sum('discount_rp')) }}
                    </span>
                </td>
                <td>
                    ?
                </td>
                <td>
                    ?
                </td>
            </tr>
        </tbody>
    </table>
</div>