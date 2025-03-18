<div id="confirmation{{ $order->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmationTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="confirmationTitle">Perbarui Status Sales Order</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-flex justify-content-between">
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">No. SO</label>
                <span class="badge {{ // $order->order_status === 'Menunggu persetujuan' ? 'bg-purple' : 
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
            </div>
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">Nama Lembaga</label>
                <h4>{{ $order->customer->NamaLembaga }}</h4>
            </div>
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">Nama Customer</label>
                <h4>{{ $order->customer->NamaCustomer }}</h4>
            </div>
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">Sales</label>
                <h4>{{ explode(' ', $order->customer->employee->name)[0] }}</h4>
            </div>
        </div>
        <div class="modal-footer">
            <!-- Batalkan -->
            <div class="col">
                <form action="{{ route('so.cancelledStatus') }}" method="POST" class="confirmation-form">
                    @method('put')
                    @csrf
                    <input type="hidden" name="id" value="{{ $order->id }}">
                    <button type="submit" class="btn btn-warning w-100 me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Batalkan">
                        <i class="fa fa-times me-2" aria-hidden="true"></i>
                        Batalkan
                    </button>
                </form>
            </div>
            <!-- Tolak -->
            <div class="col">
                <form action="{{ route('so.declinedStatus') }}" method="POST" class="confirmation-form">
                    @method('put')
                    @csrf
                    <input type="hidden" name="id" value="{{ $order->id }}">
                    <button type="submit" class="btn btn-danger w-100 me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Tolak">
                        <i class="fa fa-dot-circle-o me-2" aria-hidden="true"></i>
                        Tolak
                    </button>
                </form>
            </div>
            <!-- Setujui -->
            <div class="col">
                <form action="{{ route('so.approvedStatus') }}" method="POST" class="confirmation-form">
                    @method('put')
                    @csrf
                    <input type="hidden" name="id" value="{{ $order->id }}">
                    <button type="submit" class="btn btn-success w-100 me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Setujui">
                        <i class="fa fa-check me-2" aria-hidden="true"></i>
                        Setujui
                    </button>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>