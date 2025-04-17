<div class="dt-responsive table-responsive">
    <h4>Detail Produk</h4>
        <table class="table nowrap mb-5">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th width="12%">Kategori</th>
                    <th width="7%" class="bg-secondary">Dipesan</th>
                    <th width="7%" class="bg-success">Terkirim</th>
                    <th width="9%" class="bg-primary">Dalam Pengiriman</th>
                    <th width="7%" class="bg-warning">Siap Kirim</th>
                    <th width="8%" class="bg-danger">Belum Dikirim</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderDetails as $item)
                <tr>
                    <td><b>{{ $item->product->product_name }}</b></td>
                    <td>{{ $item->product->category->name }}</td>
                    <th>{{ number_format($item->quantity) }}</th>
                    <!-- Terkirim -->
                    <th class="text-center text-success">
                        @if ($item->delivered == 0)
                        -
                        @else
                        {{ number_format($item->delivered) }}
                        @endif
                    </th>
                    <!-- Dalam Pengiriman -->
                    <th class="text-center text-primary">
                        @if ($item->sent == 0 || $item->quantity === $item->delivered)
                        -
                        @else
                        {{ number_format($item->sent) }}
                        @endif
                    </th>
                    <!-- Siap dikirim -->
                    <th class="text-center text-secondary">
                        @if ($item->ready_to_send == 0 || $item->quantity === $item->delivered)
                        -
                        @else
                        {{ number_format($item->ready_to_send) }}
                        @endif
                    </th>
                    <!-- Belum dikirim -->
                    <th class="text-center text-danger">
                        @if ($item->to_send == 0 || $item->quantity === $item->delivered)
                        -
                        @else
                        {{ number_format($item->to_send) }}
                        @endif
                    </th>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="text-center bg-gray-200">
                <th class="text-end">Total</th>
                <th>Rp {{ number_format($order->sub_total) }}</th>
                <th class="text-white bg-secondary">{{ number_format($orderDetails->sum('quantity')) }}</th>
                <th class="text-white bg-success">{{ number_format($orderDetails->sum('delivered')) }}</th>
                <th class="text-white bg-primary">{{ number_format($orderDetails->sum('sent')) }}</th>
                <th class="text-white bg-warning">{{ number_format($orderDetails->sum('ready_to_send')) }}</th>
                <th class="text-white bg-danger">{{ number_format($orderDetails->sum('to_send')) }}</th>
            </tfoot>
        </table>

    @if ($deliveries->count() > 0)
    <h4>Riwayat Pengiriman</h4>
        <table class="table nowrap mb-5">
            <thead>
                <tr>
                    <th width="120px">Pengiriman</th>
                    <th width="180px">Tanggal DO</th>
                    <th width="150px">Nomor DO</th>
                    <th width="130px">Total Produk</th>
                    <th width="140px">Subtotal</th>
                    <th>Terpacking</th>
                    <th>Dikirim</th>
                    <th>Terkirim</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deliveries as $delivery)
                <tr>
                    <td class="text-center">ke- <span class="fw-bold fs-5">{{ $loop->iteration  }}</span></td>
                    <td>{{ Carbon\Carbon::parse($delivery->delivery_date)->translatedformat('l, d F Y') }}</td>
                    <td>
                        <div class="d-flex justify-content-between">
                            <a class="badge bg-primary" href="{{ route('do.deliveryDetails', $delivery->id) }}" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">{{ $delivery->invoice_no }}
                            </a>
                            <a href="{{ route('do.invoiceDownload', $delivery->id) }}"
                                class="badge bg-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Dokumen">
                                <i class="fa fa-print" aria-hidden="true"></i> 
                            </a>
                        </div>
                    </td>
                    <td><span class="fw-bold fs-6 me-1">{{ number_format($delivery->total_products) }}</span> {{ $item->product->category->productunit->name }}</td>
                    <td class="accounting subtotal">{{ number_format($delivery->sub_total) }}</td>
                    <td>{{ $delivery->packed_at ? Carbon\Carbon::parse($delivery->packed_at)->translatedFormat('H:i - l, d M Y') : '-' }}</td>
                    <td>{{ $delivery->sent_at ? Carbon\Carbon::parse($delivery->sent_at)->translatedFormat('H:i - l, d M Y') : '-' }}</td>
                    <td>{{ $delivery->delivered_at ? Carbon\Carbon::parse($delivery->delivered_at)->translatedFormat('H:i - l, d M Y') : '-' }}</td>
                    <td>
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
                            @if ($delivery->delivery_status === 'Siap dikirim')
                                <a href="#" class="badge bg-danger w-100" data-bs-toggle="modal" data-bs-target="#sent{{ $delivery->id }}">{{ $delivery->delivery_status }}</a>
                                @include('warehouse.delivery.partials.modal-sent')
                            @elseif ($delivery->delivery_status === 'Dalam Pengiriman')
                                <a href="#" class="badge bg-warning w-100" data-bs-toggle="modal" data-bs-target="#delivered{{ $delivery->id }}">{{ $delivery->delivery_status }}</a>
                                @include('warehouse.delivery.partials.modal-delivered')
                            @else
                                <span class="badge bg-success w-100">{{ $delivery->delivery_status }}</span>
                            @endif
                        @else
                            @if ($delivery->delivery_status === 'Siap dikirim')
                                <span class="badge bg-danger w-100">{{ $delivery->delivery_status }}</span>
                            @elseif ($delivery->delivery_status === 'Dalam Pengiriman')
                                <span class="badge bg-warning w-100">{{ $delivery->delivery_status }}</span>
                            @else
                                <span class="badge bg-success w-100">{{ $delivery->delivery_status }}</span>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    <h4>Rekap Pengiriman</h4>
        <table class="table text-center">
            <thead>
                <tr>
                    <th>Total Pengiriman</th>
                    <th class="bg-success">Total Produk Terkirim</th>
                    <th class="bg-success">Subtotal Barang Terkirim</th>
                    <th class="bg-danger">Total Produk Belum dikirim</th>
                    <th class="bg-danger">Subtotal Belum dikirim</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td><span class="fw-bold fs-5 me-1">{{ $deliveries->count('order_id') }}</span> kali</td>
                    <td><span class="fw-bold fs-6 text-success me-1">{{ $deliveries->filter(fn($d) => $d->delivery_status === 'Terkirim')->sum('total_products') }}</span> {{ $item->product->category->productunit->name }}</td>
                    <th class="text-success">Rp {{ number_format($deliveries->filter(fn($d) => $d->delivery_status === 'Terkirim')->sum('sub_total')) }}</th>
                    <td>
                        <span class="fw-bold fs-6 text-danger me-1">
                            {{ $order->total_products 
                                - $deliveries->filter(fn($d) => $d->delivery_status === 'Siap dikirim')->sum('total_products')
                                - $deliveries->filter(fn($d) => $d->delivery_status === 'Dalam Pengiriman')->sum('total_products')
                                - $deliveries->filter(fn($d) => $d->delivery_status === 'Terkirim')->sum('total_products') 
                            }}
                        </span> 
                        {{ $item->product->category->productunit->name }}
                    </td>
                    <th class="text-danger">Rp {{ number_format($order->sub_total - $deliveries->sum('sub_total')) }}</th>
                </tr>
            </tbody>
        </table>
    @else
        <div class="alert alert-danger text-center" role="alert">
            <strong>
                Pesanan dengan Nomor {{ $order->invoice_no }} belum ada pengiriman.
            </strong>
        </div>
    @endif
</div>

{{-- <table class="table table-striped table-bordered nowrap mb-3">
    <thead>
        <tr>
            <th>No.</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Pengiriman ke-1</th>
            <th>Pengiriman ke-2</th>
            <th>Pengiriman ke-3</th>
            <th>Belum dikirim</th>
        </tr>
    </thead>
    <tbody class="light-data">
        @foreach ($orderDetails as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td><b>{{ $item->product->product_name }}</b>
                    <p>{{ $item->product->category->name }}</p>
                </td>
                <td class="text-center">
                    <b class="mr-1">{{ number_format($item->quantity) }}</b> 
                </td>
                
                @php
                    // Ambil semua delivery terkait dengan order dan produk saat ini
                    $deliveries = $deliveryDetails->where('product_id', $item->product_id);
                    $maxDeliveries = 3; // Misal kita ingin menampilkan 3 pengiriman
                @endphp
                
                @if ($deliveries->count() > 0)
                    @foreach ($deliveries->take($maxDeliveries) as $index => $delivery)
                        <td class="text-center">
                            <b class="mr-1">{{ number_format($delivery->quantity) }}</b> 
                        </td>
                    @endforeach
                    
                    <!-- Jika jumlah pengiriman kurang dari maksimal, tampilkan kolom kosong -->
                    @for ($i = $deliveries->count(); $i < $maxDeliveries; $i++)
                        <td class="text-center">-</td>
                    @endfor
                @else
                    <!-- Jika tidak ada pengiriman, tampilkan kolom kosong -->
                    @for ($i = 0; $i < $maxDeliveries; $i++)
                        <td class="text-center">-</td>
                    @endfor
                @endif
            </tr>
        @endforeach
    </tbody>
</table> --}}