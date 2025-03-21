<div id="sent{{ $delivery->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="sentTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="sentTitle">Perbarui Status Delivery Order</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-flex justify-content-between bg-gray-100">
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">No. DO</label>
                <span class="badge 
                    {{ 
                        // $delivery->order_status === 'Menunggu persetujuan' ? 'bg-purple' : 
                        (strpos($delivery->invoice_no, '-RO') !== false ? 'bg-primary' : 
                        (strpos($delivery->invoice_no, '-HO') !== false ? 'bg-danger' : 
                        (strpos($delivery->invoice_no, '-RS') !== false ? 'bg-success' : 
                        (strpos($delivery->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary')))) }}"  
                        href="{{ route('so.orderDetails', $delivery->id) }}" 
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="Lihat Detail Pesanan">
                        {{ $delivery->invoice_no }}
                </span>
            </div>
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">No. SO</label>
                <span class="badge 
                    {{ 
                        // $delivery->salesorder->order_status === 'Menunggu persetujuan' ? 'bg-purple' : 
                        (strpos($delivery->salesorder->invoice_no, '-RO') !== false ? 'bg-primary' : 
                        (strpos($delivery->salesorder->invoice_no, '-HO') !== false ? 'bg-danger' : 
                        (strpos($delivery->salesorder->invoice_no, '-RS') !== false ? 'bg-success' : 
                        (strpos($delivery->salesorder->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary')))) }}"  
                        href="{{ route('so.orderDetails', $delivery->salesorder->id) }}" 
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="Lihat Detail Pesanan">
                        {{ $delivery->salesorder->invoice_no }}
                </span>
            </div>
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">Nama Lembaga</label>
                <h4>{{ $delivery->salesorder->customer->NamaLembaga }}</h4>
            </div>
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">Nama Customer</label>
                <h4>{{ $delivery->salesorder->customer->NamaCustomer }}</h4>
            </div>
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">Sales</label>
                <h4>{{ explode(' ', $delivery->salesorder->customer->employee->name)[0] }}</h4>
            </div>
        </div>
        
        <div class="modal-body">
            <div class="d-flex justify-content-between">
                <span class="btn btn-danger disabled">Pastikan data yang Anda masukkan sudah benar!</span>
                <form action="{{ route('do.sentStatus') }}" method="POST" class="confirmation-form">
                    @method('put')
                    @csrf
                    <input type="hidden" name="id" value="{{ $delivery->id }}">
                    <button class="btn btn-light-success w-100"><i class="fa fa-truck me-2"></i>Dalam Pengiriman</button>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>