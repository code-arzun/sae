<div class="tab-pane fade show active" id="salesorder" role="tabpanel">
    <!-- Data Transaksi -->
    <table class="table bg-white nowrap">
        <thead>
            <tr class="text-center">
                <th>No.</th>
                <th>Tgl. Pesan</th>
                <th width="160px">No. SO</th>
                <th>Subtotal</th>
                <th>Diskon</th>
                <th>Grand Total</th>
                <th>Status</th>
                <th>Pengiriman</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($order->order_date)->translatedformat('l, d F Y') }}">
                        {{ Carbon\Carbon::parse($order->order_date)->translatedformat('d F Y') }}
                    </span>
                </td>
                <td>
                    <div class="d-flex justify-content-between">
                        <a class=
                            "badge {{ 
                                // $order->order_status === 'Menunggu persetujuan' ? 'bg-purple-500' : 
                                (strpos($order->invoice_no, '-RO') !== false ? 'bg-primary' : 
                                (strpos($order->invoice_no, '-HO') !== false ? 'bg-danger' : 
                                (strpos($order->invoice_no, '-RS') !== false ? 'bg-success' : 
                                (strpos($order->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))))
                            }}"
                                href="{{ route('so.orderDetails', $order->id) }}" 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                title="Lihat Detail Pesanan">
                            {{ $order->invoice_no }}
                        </a>
                        <a href="{{ route('so.invoiceDownload', $order->id) }}"
                            class="badge bg-info" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Cetak Dokumen SO">
                            <i class="fa fa-print me-0" aria-hidden="true"></i> 
                        </a>
                    </div>
                </td>
                <td class="text-end"><span class="text text-green-600">Rp {{ number_format($order->sub_total) }}</span></td>
                <td class="text-end">
                    <div class="d-flex justify-content-between">
                        <span class="text text-warning">{{ number_format($order->discount_percent, 2) }}%</span>
                        <span class="text text-danger">Rp {{ number_format($order->discount_rp) }}</span>
                    </div>
                </td>
                <td class="text-end"><span class="text text-primary">Rp {{ number_format($order->grandtotal) }}</span></td>
                <td class="text-center">
                    <span class="badge {{ 
                            strpos($order->order_status, 'Menunggu persetujuan') !== false ? 'bg-warning' : 
                            (strpos($order->order_status, 'Disetujui') !== false ? 'bg-primary' : 
                            (strpos($order->order_status, 'Selesai') !== false ? 'bg-success' : 
                            (strpos($order->order_status, 'Ditolak') !== false ? 'bg-danger' : 'bg-secondary'))) }}" 
                            href="{{ route('so.orderDetails', $order->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Pesanan">
                        {{ $order->order_status }}
                    </span>
                    @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']) && $order->order_status === 'Menunggu persetujuan')
                    <div class="d-flex align-items-center list-action">
                        <!-- Setujui -->
                        <form action="{{ route('so.approvedStatus') }}" method="POST" class="confirmation-form">
                            @method('put')
                            @csrf
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            <button type="button" class="btn btn-success me-2 update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Setujui">
                                <i class="fa fa-check me-0" aria-hidden="true"></i>
                            </button>
                        </form>
                        <!-- Tolak -->
                        <form action="{{ route('so.declinedStatus') }}" method="POST" class="confirmation-form">
                            @method('put')
                            @csrf
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            <button type="button" class="btn btn-danger me-2 update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Tolak">
                                <i class="fa fa-dot-circle-o me-0" aria-hidden="true"></i>
                            </button>
                        </form>
                        <!-- Batalkan -->
                        <form action="{{ route('so.cancelledStatus') }}" method="POST" class="confirmation-form">
                            @method('put')
                            @csrf
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            <button type="button" class="btn btn-warning update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Batalkan">
                                <i class="fa fa-times me-0" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-between">
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']) && $order->order_status === 'Disetujui')
                        <a class="btn bg-purple" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Cetak Dokumen Penyiapan Produk"
                                href="{{ route('do.printPenyiapan', $order->id) }}">
                                <i class="fa fa-print me-0" aria-hidden="true"></i>
                        </a>

                        @endif
                    </div>
                </td>
                <td class="text-center">
                    @if ($order->payment_status === 'Lunas')
                        <span class="badge bg-success">{{ $order->payment_status }}</span>
                    @elseif ($order->payment_status === 'Belum Lunas')
                        <span class="badge bg-warning">{{ $order->payment_status }}</span>
                    @else
                        <span class="badge bg-danger">{{ $order->payment_status }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Rekap -->
    <h4>Total</h4>
    <table class="table table-striped table-bordered nowrap">
        <thead>
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
                <td>{{ $orders->count('due') }}</td>
                <td>
                    <span class="badge bg-warning">
                    Rp {{ number_format($orders->sum('sub_total')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-danger">
                    Rp {{ number_format($orders->sum('discount_rp')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-success">
                    Rp {{ number_format($orders->sum('grandtotal')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-warning">
                    Rp {{ number_format($orders->sum('sub_total')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-success">
                    Rp {{ number_format($orders->sum('pay')) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-danger">
                    Rp {{ number_format($orders->sum('due')) }}
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>