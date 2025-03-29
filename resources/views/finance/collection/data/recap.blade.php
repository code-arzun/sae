<!-- Rekap -->
<div class="col-lg-12 m-3">
    <div class="dt-responsive table-responsive mb-3">
        <table class="table mb-0">
            <thead class="badge-white text-uppercase">
                <tr>
                    <th>Jumlah Transaksi</th>
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
                    <td>{{ $collections->count('sub_total') }}</td>
                    <td>
                        <span class="btn badge-warning text-white">
                           Rp {{ number_format($collections->sum('sub_total')) }}
                        </span>
                    </td>
                    <td>
                        <span class="btn badge-danger text-white">
                           Rp {{ number_format($collections->sum('discount_rp')) }}
                        </span>
                    </td>
                    <td>
                        <span class="btn badge-success text-white">
                           Rp {{ number_format($collections->sum('grandtotal')) }}
                        </span>
                    </td>
                    <td>
                        <span class="btn badge-warning text-white">
                           Rp {{ number_format($collections->sum('sub_total')) }}
                        </span>
                    </td>
                    <td>
                        <span class="btn badge-danger text-white">
                           Rp {{ number_format($collections->sum('pay')) }}
                        </span>
                    </td>
                    <td>
                        <span class="btn badge-success text-white">
                           Rp {{ number_format($collections->sum('due')) }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
   
    </div>
</div>