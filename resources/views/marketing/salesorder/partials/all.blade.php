<div class="tab-pane fade show active" id="all" role="tabpanel">
    <!-- Row & Pencarian -->
    {{-- <form action="{{ route('so.index') }}" method="get"> --}}
    <form action="#" method="get">
        <div class="row d-flex justify-content-between align-items-start">
            {{-- <div class="form-group col-sm-2">
                <select class="form-control" name="order_status"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Status SO" onchange="this.form.submit()">
                    <option selected disabled>-- Status SO --</option>
                    <option value="" @if(request('order_status') == 'null') selected="selected" @endif>Semua</option>
                    @foreach ($orderStatus as $status)
                        <option value="{{ $status }}" {{ request('order_status') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div> --}}
            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
            <div class="form-group col-sm-2">
                <select name="employee_id" id="employee_id" class="form-control"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Sales" onchange="this.form.submit()">
                    <option selected disabled>-- Pilih Sales --</option>
                    <option value="" @if(request('employee_id') == 'null') selected="selected" @endif>Semua</option>
                    @foreach($sales as $employee)
                    <option value="{{ $employee->employee_id }}" {{ request('employee_id') == $employee->employee_id ? 'selected' : '' }}>
                        {{ $employee->employee->name }}
                    </option>
                @endforeach
                </select>
            </div>
            @endif
            <div class="form-group col-sm-2">
                <select name="invoice_no" id="invoice_no" class="form-control"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan jenis SO" onchange="this.form.submit()">
                    <option selected disabled>-- Pilih Kode SO --</option>
                    <option value="" @if(request('invoice_no') == 'null') selected="selected" @endif>Semua</option>
                    <option value="RO" @if(request('invoice_no') == 'RO') selected="selected" @endif>SO Reguler</option>
                    <option value="HO" @if(request('invoice_no') == 'HO') selected="selected" @endif>SO HET</option>
                    <option value="RS" @if(request('invoice_no') == 'RS') selected="selected" @endif>SO Reguler Online</option>
                    <option value="HS" @if(request('invoice_no') == 'HS') selected="selected" @endif>SO HET Online</option>
                </select>
            </div>
            <div class="form-group col-sm">
                <input type="text" id="search" class="form-control" name="search" 
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Ketik untuk melakukan pencarian!"
                    onblur="this.form.submit()" placeholder="Ketik disini untuk melakukan pencarian!" value="{{ request('search') }}">
            </div>
        </div>
    </form>

    {{-- <div class="col-lg-12">
        @if (session()->has('success'))
            <div class="alert text-white text-success" role="alert">
                <div class="iq-alert-text">{{ session('success') }}</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
                </button>
            </div>
        @endif
        <div class="d-flex flex-wrap align-items-top justify-content-between">
            <div>
                <a href="{{ url()->previous() }}" class="text text-primary mb-3 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left mb-1 mt-1"></i></a>
                <a href="{{ route('so.index') }}" class="text text-secondary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
            </div>
            <div class="d-flex flex-wrap align-items-top justify-content-between">
                <h3 class="mr-3">Sales Order</h3>
                @if (auth()->user()->hasAnyRole('Super Admin', 'Admin', 'Admin Gudang'))
                    <div>
                        <a href="{{ route('so.exportData') }}" class="text bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Excel"><i class="fa fa-file-excel"></i></a>
                    </div>
                @endif
            </div>
        </div>
    </div> --}}

    <!-- Tabel Data -->
    <table class="table bg-white nowrap mb-3">
        <thead>
            <tr>
                <th width="5px">No.</th>
                <th>Tgl. Pesan</th>
                <th width="200px">No. SO</th>
                <th>Customer</th>
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                <th>Sales</th>
                @endif
                <th>Subtotal</th>
                <th>Diskon</th>
                <th>Grand Total</th>
                <th class="bg-primary">Status SO</th>
                <th class="bg-secondary">
                    <a href="{{ route('do.all') }}" class="text-white">
                        <i class="fa-solid fa-truck me-1"></i>Delivery Order
                    </a>
                </th>
                <th class="bg-purple">
                    <a href="{{ route('collection.all') }}" class="text-white">
                        <i class="fa fa-money me-1"></i>Collection
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($order->order_date)->translatedformat('l, d F Y') }}">
                        {{ Carbon\Carbon::parse($order->order_date)->translatedformat('d M Y') }}
                    </span>
                </td>
                <td>
                    <div class="d-flex justify-content-between align-items-center">
                        <a class="badge 
                            {{ 
                                // $order->order_status === 'Menunggu persetujuan' ? 'bg-purple' : 
                                (strpos($order->invoice_no, '-RO') !== false ? 'bg-primary' : 
                                (strpos($order->invoice_no, '-HO') !== false ? 'bg-danger' : 
                                (strpos($order->invoice_no, '-RS') !== false ? 'bg-success' : 
                                (strpos($order->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary')))) }}"  
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
                <td>
                    <h6>{{ $order->customer->NamaLembaga }}</h6>
                    <span class="text-secondary">{{ $order->customer->NamaCustomer }}</span>
                </td>
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                <td>{{ explode(' ', $order->customer->employee->name)[0] }}</td>
                @endif
                <td class="text-end"><span class="text text-success">Rp {{ number_format($order->sub_total) }}</span></td>
                <td class="text-end">
                    <div class="d-flex justify-content-between">
                        <span class="text text-warning">{{ number_format($order->discount_percent, 2) }}%</span>
                        <span class="text text-danger">Rp {{ number_format($order->discount_rp) }}</span>
                    </div>
                </td>
                <td class="text-end"><span class="text text-primary">Rp {{ number_format($order->grandtotal) }}</span></td>
                @if ($order->order_status === 'Selesai' && $order->shipping_status === 'Terkirim' && $order->payment_status === 'Lunas')
                    <td colspan="3">
                        <span class="btn btn-success w-100">Transaksi Selesai</span>
                    </td>
                @elseif ($order->order_status === 'Menunggu persetujuan')
                    <td colspan="3">
                        <div class="row align-middle">
                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                                <div class="col-md-9">
                                    <span class="btn btn-secondary w-100">Menunggu Persetujuan Manajer Marketing</span>
                                </div>
                                <div class="col ml-3 d-flex align-items-center">
                                    <!-- Batalkan -->
                                    <form action="{{ route('so.cancelledStatus') }}" method="POST" class="confirmation-form">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $order->id }}">
                                        <button type="button" class="btn btn-warning me-2 update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Batalkan">
                                            <i class="fa fa-times me-0" aria-hidden="true"></i>
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
                                    <!-- Setujui -->
                                    <form action="{{ route('so.approvedStatus') }}" method="POST" class="confirmation-form">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $order->id }}">
                                        <button type="button" class="btn btn-success update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Setujui">
                                            <i class="fa fa-check me-0" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text bg-secondary w-100">Menunggu Persetujuan Manajer Marketing</span>
                            @endif
                        </div>
                    </td>
                @elseif ($order->order_status === 'Ditolak')
                    <td colspan="3">
                        <span class="text bg-danger w-100">Ditolak</span>
                    </td>
                @elseif ($order->order_status === 'Dibatalkan')
                    <td colspan="3">
                        <span class="text bg-danger w-100">Dibatalkan</span>
                    </td>
                @else
                    <!-- Status SO -->
                    <td class="text-center">
                        @if ($order->order_status === 'Disetujui' && $order->shipping_status === 'Terkirim' && $order->payment_status === 'Lunas')
                            <span data-bs-toggle="tooltip" class="text text-purple">{{ $order->order_status }}</span>
                            <form action="{{ route('so.finishedStatus') }}" method="POST" class="confirmation-form">
                                @method('put')
                                @csrf
                                <input type="hidden" name="id" value="{{ $order->id }}">
                                <button type="button" class="btn btn-primary me-2 update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Selesai">
                                    <i class="fa fa-check me-0" aria-hidden="true"></i>
                                </button>
                            </form>
                        @else 
                            <span data-bs-toggle="tooltip" class="text text-purple">{{ $order->order_status }}</span>
                        @endif
                    </td>
                    <!-- Status DO -->
                    <td class="text-center">
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']) && $order->order_status === 'Disetujui' && $order->shipping_status === 'Pengiriman ke-1')
                            <div class="d-flex justify-content-between">
                                <a class="text btn-purple" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Cetak Dokumen Penyiapan Produk"
                                    href="{{ route('do.printPenyiapan', $order->id) }}">
                                    <i class="fa fa-print me-0" aria-hidden="true"></i>
                                </a>
                                <form action="{{ route('so.shippingStatus') }}" method="POST" class="confirmation-form">
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $order->id }}">
                                    <input type="hidden" name="shipping_status" id="shipping_status_{{ $order->id }}">
                                
                                    <div class="btn-group">
                                        <a class="text text-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-solid fa-truck" data-bs-toggle="tooltip" data-bs-placement="top" title="Perbarui status pengiriman"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-left">
                                            <button type="submit" class="dropdown-item" onclick="setShippingStatus({{ $order->id }}, 'Pengiriman ke-1')">Pengiriman ke-1</button>
                                            <button type="submit" class="dropdown-item" onclick="setShippingStatus({{ $order->id }}, 'Pengiriman ke-2')">Pengiriman ke-2</button>
                                            <button type="submit" class="dropdown-item" onclick="setShippingStatus({{ $order->id }}, 'Pengiriman ke-3')">Pengiriman ke-3</button>
                                            <button type="submit" class="dropdown-item" onclick="setShippingStatus({{ $order->id }}, 'Pengiriman ke-4')">Pengiriman ke-4</button>
                                            <button type="submit" class="dropdown-item" onclick="setShippingStatus({{ $order->id }}, 'Pengiriman ke-5')">Pengiriman ke-5</button>
                                            <button type="submit" class="dropdown-item" onclick="setShippingStatus({{ $order->id }}, 'Terkirim')">Terkirim</button>
                                        </div>
                                    </div>
                                </form>
                        @endif
                                @if ($order->shipping_status === 'Terkirim' && $order->order_status === 'Selesai')
                                @elseif ($order->shipping_status === 'Terkirim')
                                    <span data-bs-toggle="tooltip" class="text text-success">{{ $order->shipping_status }}</span>
                                @else
                                    <span data-bs-toggle="tooltip" class="text text-warning">{{ $order->shipping_status }}</span>
                                @endif
                        </div>
                    </td>
                    <!-- Status Collection -->
                    <td class="text-center">
                        @if ($order->payment_status === 'Lunas')
                            <span data-bs-toggle="tooltip" class="text text-success">{{ $order->payment_status }}</span>
                        @elseif ($order->payment_status === 'Belum Lunas')
                            <span data-bs-toggle="tooltip" class="text text-warning">{{ $order->payment_status }}</span>
                        @else
                            <span data-bs-toggle="tooltip" class="text text-danger">{{ $order->payment_status }}</span>
                        @endif
                    </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}

    <!-- Rekap -->
    <table class="table bg-white">
        <thead class="text-white text-uppercase">
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
        <tbody class="light-body text-center">
            <tr>
                <td>{{ $orders->count('due') }}</td>
                <td>
                    <span class="text bg-warning text-white">
                       Rp {{ number_format($orders->sum('sub_total')) }}
                    </span>
                </td>
                <td>
                    <span class="text bg-danger text-white">
                       Rp {{ number_format($orders->sum('discount_rp')) }}
                    </span>
                </td>
                <td>
                    <span class="text bg-success text-white">
                       Rp {{ number_format($orders->sum('grandtotal')) }}
                    </span>
                </td>
                <td>
                    <span class="text bg-warning text-white">
                       Rp {{ number_format($orders->sum('sub_total')) }}
                    </span>
                </td>
                <td>
                    <span class="text bg-success text-white">
                       Rp {{ number_format($orders->sum('pay')) }}
                    </span>
                </td>
                <td>
                    <span class="text bg-danger text-white">
                       Rp {{ number_format($orders->sum('due')) }}
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    function setShippingStatus(orderId, status) {
        document.getElementById('shipping_status_' + orderId).value = status;
    }
</script>