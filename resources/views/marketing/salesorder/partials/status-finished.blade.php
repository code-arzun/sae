<div id="finished{{ $order->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="finishedTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="finishedTitle">Perbarui Status Sales Order</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-flex justify-content-between">
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">No. SO</label>
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
            <form action="{{ route('so.finishedStatus') }}" method="POST" class="confirmation-form">
                @method('put')
                @csrf
                <input type="hidden" name="id" value="{{ $order->id }}">
                <button class="btn btn-light-primary">Selesai</button>
            </form>
        </div>
      </div>
    </div>
</div>