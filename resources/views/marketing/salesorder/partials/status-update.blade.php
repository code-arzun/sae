<div id="confirmation{{ $order->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmationTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmationTitle">Perbarui Status Sales Order</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <table class="table text-center">
            <thead>
                <th>No. SO</th>
                <th>Nama Lembaga</th>
                <th>Nama Customer</th>
                <th>Sales</th>
            </thead>
            <tbody>
                <td>
                    <span class="badge 
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
                    </span>
                </td>
                <td><h6 class="mb-0">{{ $order->customer->NamaLembaga }}</h6></td>
                <td><span class="text-secondary">{{ $order->customer->NamaCustomer }}</span></td>
                <td><h6>{{ $order->customer->employee->name }}</h6></td>
            </tbody>
        </table>
        <div class="modal-footer">
          <!-- Batalkan -->
          <form action="{{ route('so.cancelledStatus') }}" method="POST" class="confirmation-form">
            @method('put')
            @csrf
            <input type="hidden" name="id" value="{{ $order->id }}">
            <button type="submit" class="btn btn-warning me-2 update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="Batalkan" data-original-title="Batalkan">
                <i class="fa fa-times me-2" aria-hidden="true">Batalkan</i>
            </button>
        </form>
        <!-- Tolak -->
        <form action="{{ route('so.declinedStatus') }}" method="POST" class="confirmation-form">
            @method('put')
            @csrf
            <input type="hidden" name="id" value="{{ $order->id }}">
            <button type="submit" class="btn btn-danger me-2 update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="Tolak" data-original-title="Tolak">
                <i class="fa fa-dot-circle-o me-2" aria-hidden="true">Tolak</i>
            </button>
        </form>
        <!-- Setujui -->
        <form action="{{ route('so.approvedStatus') }}" method="POST" class="confirmation-form">
            @method('put')
            @csrf
            <input type="hidden" name="id" value="{{ $order->id }}">
            <button type="submit" class="btn btn-success update-button" data-bs-toggle="tooltip" data-bs-placement="top" title="Setujui" data-original-title="Setujui">
                <i class="fa fa-check me-2" aria-hidden="true">Setujui</i>
            </button>
        </form>
        </div>
      </div>
    </div>
</div>