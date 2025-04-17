<!-- Rekap Total -->
<div class="col-md-2">
    <div class="card">
        <div class="card-body d-flex justify-content-between">
            <div class="col-md-6">
                <h5>Total Transaksi</h5>
            </div>
            <div>
                <h1 class="text-secondary">{{ $orders->count('invoice_no') }}</h1>
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
                <th>Total Tagihan</th>
                <th>Total Telah dibayar</th>
                <th>Total Belum dibayar</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr>
                <td>
                    <span class="badge bg-success text-white">
                    Rp {{ number_format($orders->sum('sub_total')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-danger text-white">
                    Rp {{ number_format($orders->sum('discount_rp')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-primary text-white">
                    Rp {{ number_format($orders->sum('grandtotal')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-warning text-white">
                    Rp {{ number_format($orders->sum('sub_total')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-success text-white">
                    Rp {{ number_format($orders->sum('pay')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-danger text-white">
                    Rp {{ number_format($orders->sum('due')) }}
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>