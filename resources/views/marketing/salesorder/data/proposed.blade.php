<div class="tab-pane fade" id="proposed" role="tabpanel">

    <!-- Row & Pencarian -->
    {{-- <form action="{{ route('so.index') }}" method="get"> --}}
    <form action="#" method="get">
        <div class="row d-flex justify-content-between align-items-start">
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

    <!-- Tabel Data -->
    <table class="table nowrap mb-3">
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
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                <th>#</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            @if ($order->order_status == 'Menunggu persetujuan')
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($order->order_date)->translatedformat('l, d F Y') }}">
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
                            class="badge bg-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Dokumen SO">
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
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
               <td>
                    <div class="col ml-3 d-flex align-items-center justify-content-between">
                        <!-- Batalkan -->
                        <form action="{{ route('so.cancelledStatus') }}" method="POST" class="confirmation-form">
                            @method('put')
                            @csrf
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            <button type="button" class="btn bg-warning me-2 update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="Batalkan">
                                <i class="fa fa-times me-0" aria-hidden="true"></i>
                            </button>
                        </form>
                        <!-- Tolak -->
                        <form action="{{ route('so.declinedStatus') }}" method="POST" class="confirmation-form">
                            @method('put')
                            @csrf
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            <button type="button" class="btn bg-danger me-2 update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="Tolak">
                                <i class="fa fa-dot-circle-o me-0" aria-hidden="true"></i>
                            </button>
                        </form>
                        <!-- Setujui -->
                        <form action="{{ route('so.approvedStatus') }}" method="POST" class="confirmation-form">
                            @method('put')
                            @csrf
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            <button type="button" class="btn bg-success update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="Setujui">
                                <i class="fa fa-check me-0" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </td>
                @endif
            </tr>
            @endif
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
        <tbody class="text-center">
            <tr>
                <td>{{ $orders->where('order_status', 'Menunggu persetujuan')->count('due') }}</td>
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