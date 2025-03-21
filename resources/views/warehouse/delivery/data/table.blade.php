<!-- Row & Pencarian -->
<form action="" method="get">
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
<table class="table table-hover bg-white nowrap mb-3">
    <thead>
        <tr>
            <!-- Partial Head -->
            @include('layout.table.so-head')
            <th class="bg-warning">
                <a href="{{ route('do.index') }}" class="text-white">
                    <i class="fas fa-truck me-3"></i>Delivery Order
                </a>
            </th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        @if($order->deliveries->isNotEmpty())
            <tr data-bs-toggle="collapse" href="#detailsDO{{ $order->id }}" role="button" aria-expanded="false" aria-controls="detailsDO{{ $order->id }}">
        @else
            </tr>
        @endif
            <!-- Partial Data -->
            @include('layout.table.so-data')
            @if ($order->order_status === 'Selesai' && $order->shipping_status === 'Terkirim' && $order->payment_status === 'Lunas')
                <td colspan="3">
                    <span class="badge bg-success w-100">Transaksi Selesai</span>
                </td>
            @else
                <!-- Status SO -->
                <td class="text-center">
                    @if ((auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']) && $order->order_status === 'Disetujui' && $order->shipping_status === 'Terkirim' && $order->payment_status === 'Lunas'))
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Perbarui status menjadi SELESAI">
                            <a href="#" class="badge bg-info w-100" data-bs-toggle="modal" data-bs-target="#finished{{ $order->id }}" data-id="{{ $order->id }}">Disetujui</a>
                        </span>
                        <!-- modal -->
                        @include('marketing.salesorder.data.status-finished')
                    @else 
                        <span data-bs-toggle="tooltip" class="badge bg-primary w-100">{{ $order->order_status }}</span>
                    @endif
                </td>
                <!-- Status DO -->
                <td class="text-center">
                    @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']) && $order->order_status === 'Disetujui' && $order->shipping_status === 'Pengiriman ke-1')
                        <div class="d-flex justify-content-between">
                            <a class="badge bg-purple-300" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Dokumen Penyiapan Produk" data-original-title="Cetak Dokumen Penyiapan Produk"
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
                                <span data-bs-toggle="tooltip" class="badge bg-success w-100">{{ $order->shipping_status }}</span>
                            @else
                                <span data-bs-toggle="tooltip" class="badge bg-danger w-100">{{ $order->shipping_status }}</span>
                            @endif
                    </div>
                </td>
                <td>
                    @if($order->deliveries->isNotEmpty())
                        <a class="badge bg-info" data-bs-toggle="collapse" href="#detailsDO{{ $order->id }}" role="button" aria-expanded="false" aria-controls="detailsDO{{ $order->id }}"><i class="ti ti-eye"></i></a>
                    @endif
                </td>
            @endif
            @if($order->deliveries->isNotEmpty())
            <tr>
                <td class="collapse" colspan="12" id="detailsDO{{ $order->id }}">
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
    
    document.querySelector('.bs-radio-input').addEventListener('click', function () {
    (async () => {
      const inputOptions = new Promise((resolve) => {
        setTimeout(() => {
          resolve({
            '#ff0000': 'Red',
            '#00ff00': 'Green',
            '#0000ff': 'Blue'
          });
        }, 1000);
      });
      const { value: color } = await Swal.fire({
        title: 'Select color',
        input: 'radio',
        inputOptions: inputOptions,
        inputValidator: (value) => {
          if (!value) {
            return 'You need to choose something!';
          }
        }
      });
      if (color) {
        Swal.fire({
          html: `You selected: ` + color
        });
      }
    })();
  });
</script>
