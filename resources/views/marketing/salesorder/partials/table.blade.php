<!-- Pencarian -->
<form action="" method="get">
    <div class="row d-flex justify-content-between align-items-start">
        <div class="form-group col-sm-2">
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
        </div>
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
            
                <optgroup label="SO Reguler">
                    <option value="RO" @if(request('invoice_no') == 'RO') selected="selected" @endif>Reguler Offline</option>
                    <option value="RS" @if(request('invoice_no') == 'RS') selected="selected" @endif>Reguler Online</option>
                </optgroup>
            
                <optgroup label="SO HET">
                    <option value="HO" @if(in_array(request('invoice_no'), ['H-'])) selected="selected" @endif>HET Offline</option>
                    <option value="HS" @if(request('invoice_no') == 'HS') selected="selected" @endif>HET Online</option>
                </optgroup>
                
            </select>
        </div>
        <div class="form-group col-sm-2">
            <select name="customer_id" id="customer_id" class="form-control"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Sales" onchange="this.form.submit()">
                <option selected disabled>-- Pilih Customer --</option>
                <option value="" @if(request('customer_id') == 'null') selected="selected" @endif>Semua</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->NamaLembaga }} - {{ $customer->NamaCustomer }}
                    </option>
                @endforeach
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
<table class="table nowrap mb-3">
    <thead>
        <tr>
            <!-- Partial Head -->
            @include('layout.table.so-head')
            <th class="bg-primary text-white"><i class="fas fa-cog me-3"></i>Status SO</th>
            <th class="bg-warning">
                <a href="{{ route('do.index') }}" class="text-white">
                    <i class="fas fa-truck me-3"></i>Delivery Order
                </a>
            </th>
            <th class="bg-danger">
                <a href="{{ route('collection.index') }}" class="text-white">
                    <i class="fas fa-money-bill-alt me-3"></i>Collection
                </a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <!-- Partial Head -->
            @include('layout.table.so-data')
            @if ($order->order_status === 'Selesai' && $order->shipping_status === 'Terkirim' && $order->payment_status === 'Lunas')
                <td colspan="3">
                    <span class="badge bg-success w-100">Transaksi Selesai</span>
                </td>
            @elseif ($order->order_status === 'Menunggu persetujuan')
                <td colspan="3">
                    <div class="row align-middle">
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                            <div class="col">
                                <a href="#" class="badge btn-light-warning w-100" data-bs-toggle="modal" data-bs-target="#confirmation{{ $order->id }}" data-id="{{ $order->id }}">Menunggu Persetujuan Manajer Marketing</a>
                                @include('marketing.salesorder.data.status-update')
                            </div>
                        @else
                            <div class="col">
                                <span class="badge bg-warning w-100">Menunggu Persetujuan Manajer Marketing</span>
                            </div>
                        @endif
                    </div>
                </td>
            @elseif ($order->order_status === 'Ditolak' || $order->order_status === 'Dibatalkan')
                <td colspan="3">
                    <span class="badge bg-danger w-100">{{ $order->order_status }}</span>
                </td>
            @else
                <!-- Status SO -->
                <td class="text-center">
                    @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']) && $order->order_status === 'Disetujui' && $order->shipping_status === 'Terkirim' && $order->payment_status === 'Lunas')
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Perbarui status menjadi SELESAI">
                            <a href="#" class="badge btn-light-success w-100" data-bs-toggle="modal" data-bs-target="#finished{{ $order->id }}" data-id="{{ $order->id }}">Disetujui</a>
                        </span>
                        <!-- modal -->
                        @include('marketing.salesorder.data.status-finished')
                    @else 
                        <span data-bs-toggle="tooltip" class="badge bg-primary w-100">{{ $order->order_status }}</span>
                    @endif
                </td>
                <!-- Status DO -->
                <td class="text-center">
                    <div class="d-flex justify-content-between">
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
                            <!-- Shipping Update -->
                            @include('layout.partials.shipping-update')
                        @endif
                        @if ($order->shipping_status === 'Terkirim')
                            <a class="badge bg-success w-100" data-bs-toggle="collapse" href="#detailsDO{{ $order->id }}" aria-expanded="false" aria-controls="detailsDO{{ $order->id }}">{{ $order->shipping_status }}</a>
                            @elseif ($order->shipping_status === 'Belum ada pengiriman')
                            <a class="badge bg-danger w-100" data-bs-toggle="collapse" href="#detailsDO{{ $order->id }}" aria-expanded="false" aria-controls="detailsDO{{ $order->id }}">{{ $order->shipping_status }}</a>    
                            @else
                            <a class="badge bg-info w-100" data-bs-toggle="collapse" href="#detailsDO{{ $order->id }}" aria-expanded="false" aria-controls="detailsDO{{ $order->id }}">{{ $order->shipping_status }}</a>    
                        @endif                        
                    </div>
                </td>
                <!-- Status Collection -->
                <td class="text-center">
                    @if ($order->payment_status === 'Lunas')
                        <span data-bs-toggle="tooltip" class="badge bg-success w-100">{{ $order->payment_status }}</span>
                    @elseif ($order->payment_status === 'Belum Lunas')
                        <span data-bs-toggle="tooltip" class="badge bg-warning w-100">{{ $order->payment_status }}</span>
                    @else
                        <span data-bs-toggle="tooltip" class="badge bg-danger w-100">{{ $order->payment_status }}</span>
                    @endif
                </td>
                @if($order->deliveries->isNotEmpty())
            <tr>
                <td class="collapse" colspan="12" id="detailsDO{{ $order->id }}">
                    @include('warehouse.delivery.partials.details', ['deliveries' => $order->deliveries])
                </td>
            </tr>
            @endif
            
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
