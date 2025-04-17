<!-- Pencarian -->
<div class="col-lg-12">
    <form action="#" method="get">
        <div class="row align-items-start">
            <div class="form-group col-sm-2">
                <select class="form-control" name="delivery_status"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Status Pengiriman" onchange="this.form.submit()">
                    <option selected disabled>-- Status Pengiriman --</option>
                    <option value="" @if(request('delivery_status') == 'null') selected="selected" @endif>Semua</option>
                    @foreach ($deliveryStatus as $status)
                        <option value="{{ $status }}" {{ request('delivery_status') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
            <div class="form-group col-sm-2">
                <select name="employee_id" id="employee_id" class="form-control"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Sales" onchange="this.form.submit()">
                    <option selected disabled>-- Pilih Sales --</option>
                    <option value="" @if(request('employee_id') == 'null') selected="selected" @endif>Semua</option>
                    @foreach($sales as $employee)
                    <option value="{{ $employee->employee_id }}" {{ request('employee_id') == $employee->employee_id ? 'selected' : '' }}>
                        {{ $employee->employee->name }} <!-- Adjust this to display employee's name or other details -->
                    </option>
                @endforeach
                </select>
            </div>
            @endif
            <div class="form-group col-sm-1">
                <select name="delivery_invoice_no" id="delivery_invoice_no" class="form-control"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan jenis SO" onchange="this.form.submit()">
                    <option selected disabled>-- Pilih Kode DO --</option>
                    <option value="" @if(request('delivery_invoice_no') == 'null') selected="selected" @endif>Semua</option>
                    <option value="RO" @if(request('invoice_no') == 'RO') selected="selected" @endif>DO Reguler</option>
                    <option value="HO" @if(request('invoice_no') == 'HO') selected="selected" @endif>DO HET</option>
                    <option value="RS" @if(request('invoice_no') == 'RS') selected="selected" @endif>DO Reguler Online</option>
                    <option value="HS" @if(request('invoice_no') == 'HS') selected="selected" @endif>DO HET Online</option>
                </select>
            </div>
            <div class="form-group col-sm-1">
                <select name="order_invoice_no" id="order_invoice_no" class="form-control"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan jenis SO" onchange="this.form.submit()">
                    <option selected disabled>-- Pilih Kode SO --</option>
                    <option value="" @if(request('order_invoice_no') == 'null') selected="selected" @endif>Semua</option>
                    <option value="RO" @if(request('invoice_no') == 'RO') selected="selected" @endif>SO Reguler</option>
                    <option value="HO" @if(request('invoice_no') == 'HO') selected="selected" @endif>SO HET</option>
                    <option value="RS" @if(request('invoice_no') == 'RS') selected="selected" @endif>SO Reguler Online</option>
                    <option value="HS" @if(request('invoice_no') == 'HS') selected="selected" @endif>SO HET Online</option>
                </select>
            </div>
            <div class="form-group col-sm">
                <input type="text" id="search" class="form-control" name="search" 
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Ketik untuk melakukan pencarian!"
                    onkeyup="this.form.submit()" placeholder="Ketik disini untuk melakukan pencarian!" value="{{ request('search') }}">
            </div>
        </div>
    </form>
</div>

<!-- Tabel Data -->
<table class="table nowrap mb-3">
    <thead>
        <tr>
            <!-- Partial Head -->
            @include('layout.table.so-head')
            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
            <th width="50px"><i class="ti ti-file-alert"></i></th>
            @endif
            <th width="200px"><i class="fas fa-truck me-3"></i>Status Pengiriman</th>
            {{-- <th><i class="fas fa-truck me-3"></i>Jumlah Pengiriman</th> --}}
            <th><i class="fas fa-truck me-3"></i>Riwayat Pengiriman</th>
            @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Admin Gudang']))
            <th width="50px">#</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <!-- Partial Data -->
            @include('layout.table.so-data')
            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
                <td class="text-center">
                    <div class="d-flex justify-content-center">
                        <a class="badge bg-purple-300 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Dokumen Penyiapan Produk" data-original-title="Cetak Dokumen Penyiapan Produk"
                            href="{{ route('do.printPenyiapan', $order->id) }}">
                            <i class="fa fa-print me-0" aria-hidden="true"></i>
                        </a>
                        <!-- Shipping Update -->
                        @include('layout.partials.shipping-update')
                    </div>
                </td>
            @endif
            @if ($order->shipping_status === 'Belum ada pengiriman')
                <td colspan="2"><a class="badge bg-danger w-100" data-bs-toggle="collapse" href="#detailsDO{{ $order->id }}" aria-expanded="false" aria-controls="detailsDO{{ $order->id }}">{{ $order->shipping_status }}</a></td>
            @else
                <td>
                    @if ($order->shipping_status === 'Terkirim')
                        <a class="badge bg-success w-100" data-bs-toggle="collapse" href="#detailsDO{{ $order->id }}" aria-expanded="false" aria-controls="detailsDO{{ $order->id }}">{{ $order->shipping_status }}</a>
                    @else
                        <a class="badge bg-warning w-100" data-bs-toggle="collapse" href="#detailsDO{{ $order->id }}" aria-expanded="false" aria-controls="detailsDO{{ $order->id }}">{{ $order->shipping_status }}</a>    
                    @endif
                </td>
                <td>
                    @foreach($order->deliveries as $delivery)
                    <a class="badge 
                        {{ strpos($delivery->invoice_no, '-RO') !== false ? 'bg-primary' : 
                           (strpos($delivery->invoice_no, '-HO') !== false ? 'bg-danger' : 
                           (strpos($delivery->invoice_no, '-RS') !== false ? 'bg-success' : 
                           (strpos($delivery->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))) }} mt-1 mb-1" 
                       href="{{ route('do.deliveryDetails', $delivery->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" 
                       title="Lihat Detail Pengiriman">
                        {{ $delivery->invoice_no }}
                    </a>
                @endforeach
                </td>
                @endif
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Admin Gudang']))
                <td>
                    @if ($order->shipping_status === 'Terkirim')
                    @else
                        <a href="{{ route('input.do', ['order_id' => $order->id]) }}" class="badge bg-purple-500" data-bs-toggle="tooltip" data-bs-placement="top" title="Buat DO">
                            <i class="ti ti-plus"></i>
                        </a>
                    @endif
                </td>
                @endif
                @if($order->deliveries->isNotEmpty())
                    <tr>
                        <td class="collapse" colspan="14" id="detailsDO{{ $order->id }}">
                            @include('warehouse.delivery.partials.details', ['deliveries' => $order->deliveries])
                        </td>
                    </tr>
                @endif
        </tr>
        @endforeach
    </tbody>
</table>
{{ $orders->links() }}


<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/ac-alert.js') }}"></script>
<script>
    function setShippingStatus(orderId, status) {
        document.getElementById('shipping_status_' + orderId).value = status;
    }
</script>
