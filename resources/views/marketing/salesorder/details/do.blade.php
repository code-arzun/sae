<table class="table nowrap mb-3">
            <thead>
                <tr>
                    {{-- <th width="3px">No.</th> --}}
                    <th width="500px">Produk</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Belum Dikirim</th>
                    <th>Siap Kirim</th>
                    <th>Dalam Pengiriman</th>
                    <th>Terkirim</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderDetails as $item)
                <tr>
                    {{-- <td>{{ $loop->iteration  }}</td> --}}
                    <td><b>{{ $item->product->product_name }}</b></td>
                    <td>{{ $item->product->category->name }}</td>
                    <td class="text-center"><span class="badge bg-purple me-2">{{ number_format($item->quantity) }}</span>
                    </td>
                    <td class="text-center">
                        @if ($item->quantity === $item->delivered)
                        @else
                        <span class="badge bg-danger me-2">{{ number_format($item->to_send) }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($item->quantity === $item->delivered)
                        @else
                        <span class="badge bg-warning me-2">{{ number_format($item->ready_to_send) }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($item->quantity === $item->delivered)
                        @else
                        <span class="badge bg-primary me-2">{{ number_format($item->sent) }}</span>
                        @endif
                    </td>
                    <td class="text-center"><span class="badge bg-success me-2">{{ number_format($item->delivered) }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<div class="card">
    {{-- <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Delivery Order</h4>
        </div>

        @php
            $remainingAmount = $order->sub_total - $deliveries->sum('sub_total');
        @endphp

        @if ($remainingAmount > 0 && auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
        <div>
            <a href="{{ route('input.do') }}"
                class="btn bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Buat Delivery Order">
                <i class="fa fa-plus me-2" aria-hidden="true"></i>Buat Delivery Order 
            </a>
        </div>
        @endif
    </div> --}}
    <div class="dt-responsive table-responsive mb-3">
        <table class="table nowrap mb-3">
            <thead>
                <tr>
                    {{-- <th width="3px">No.</th> --}}
                    <th width="500px">Produk</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Belum Dikirim</th>
                    <th>Siap Kirim</th>
                    <th>Dalam Pengiriman</th>
                    <th>Terkirim</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderDetails as $item)
                <tr>
                    {{-- <td>{{ $loop->iteration  }}</td> --}}
                    <td><b>{{ $item->product->product_name }}</b></td>
                    <td>{{ $item->product->category->name }}</td>
                    <td class="text-center"><span class="badge bg-purple me-2">{{ number_format($item->quantity) }}</span>
                        {{ $item->product->category->productunit->name }}
                    </td>
                    <td class="text-center">
                        @if ($item->quantity === $item->delivered)
                        @else
                        <span class="badge bg-danger me-2">{{ number_format($item->to_send) }}</span>
                        {{ $item->product->category->productunit->name }}
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($item->quantity === $item->delivered)
                        @else
                        <span class="badge bg-warning me-2">{{ number_format($item->ready_to_send) }}</span>
                        {{ $item->product->category->productunit->name }}
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($item->quantity === $item->delivered)
                        @else
                        <span class="badge bg-primary me-2">{{ number_format($item->sent) }}</span>
                        {{ $item->product->category->productunit->name }}
                        @endif
                    </td>
                    <td class="text-center"><span class="badge bg-success me-2">{{ number_format($item->delivered) }}</span>
                        {{ $item->product->category->productunit->name }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="dt-responsive table-responsive">
        <table class="table table-striped table-bordered nowrap mb-3">
            <thead>
                <tr>
                    <th>Pengiriman ke-</th>
                    <th>Tanggal DO</th>
                    <th>No. DO</th>
                    <th>Dokumen</th>
                    <th>Total Produk</th>
                    <th>Total</th>
                    <th>Terpacking</th>
                    <th>Dikirim</th>
                    <th>Terkirim</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deliveries as $delivery)
                <tr class="text-center">
                    <td>{{ $loop->iteration  }}</td>
                    <td>{{ Carbon\Carbon::parse($delivery->delivery_date)->translatedformat('l, d F Y') }}</td>
                    <td>
                        <a class="badge badge-primary" href="{{ route('do.deliveryDetails', $delivery->id) }}" 
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">{{ $delivery->invoice_no }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('do.invoiceDownload', $delivery->id) }}"
                            class="btn bg-warning me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Dokumen">
                            <i class="fa fa-print me-0" aria-hidden="true"></i> 
                        </a>
                    </td>
                    <td><b class="mr-1">{{ number_format($delivery->total_products) }}</b> {{ $item->product->category->productunit->name }}</td>
                    <td class="text-end">Rp {{ number_format($delivery->sub_total) }}</td>
                    <td class="text-center">{{ $delivery->packed_at ? Carbon\Carbon::parse($delivery->packed_at)->translatedFormat('H:i - l, d M Y') : '' }}</td>
                    <td class="text-center">{{ $delivery->sent_at ? Carbon\Carbon::parse($delivery->sent_at)->translatedFormat('H:i - l, d M Y') : '' }}</td>
                    <td class="text-center">{{ $delivery->delivered_at ? Carbon\Carbon::parse($delivery->delivered_at)->translatedFormat('H:i - l, d M Y') : '' }}</td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
        <table class="table text-center">
            <thead>
                <tr>
                    <th>Jumlah Pengiriman</th>
                    <th>Total Produk Terkirim</th>
                    <th>Subtotal Barang Terkirim</th>
                    <th>Total Produk Belum dikirim</th>
                    <th>Subtotal Belum dikirim</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td><span class="badge bg-warning me-1">{{ $deliveries->count('order_id') }}</span> kali</td>
                <td><span class="badge bg-success">{{ $deliveries->sum('total_products') }}</span></td>
                <td><span class="badge bg-primary">Rp {{ number_format($deliveries->sum('sub_total')) }}</span></td>
                <td>
                    <span class="badge bg-danger">
                        {{ $order->total_products - $deliveries->sum('total_products') }}
                    </span>
                </td>
                <td><span class="badge bg-danger">Rp {{ number_format($order->sub_total - $deliveries->sum('sub_total')) }}</span></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="dt-responsive table-responsive">
        <table class="table table-striped table-bordered nowrap mb-3">
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
        </table>
    </div>
</div>