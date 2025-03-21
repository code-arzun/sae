<div id="saveDO" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="saveTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="saveTitle">Simpan Sales Order Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-flex justify-content-between">
            <div class="d-flex flex-column align-items-center text-center">
                <span class="text-secondary mb-1">Tgl. SO</span>
                <h4 class="mb-0">{{ $salesorder->order_date }}</h4>
            </div>
            <div class="d-flex flex-column align-items-center text-center">
                <span class="text-secondary mb-1">No. SO</span>
                <span class="badge me-2
                    {{ // $salesorder->order_status === 'Menunggu persetujuan' ? 'bg-purple' : 
                        (strpos($salesorder->invoice_no, '-RO') !== false ? 'bg-primary' : 
                        (strpos($salesorder->invoice_no, '-HO') !== false ? 'bg-danger' : 
                        (strpos($salesorder->invoice_no, '-RS') !== false ? 'bg-success' : 
                        (strpos($salesorder->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary')))) }}">
                        {{ $salesorder->invoice_no }}
                </span>                
            </div>
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">Nama Lembaga</label>
                <h4>{{ $salesorder->customer->NamaLembaga }}</h4>
            </div>
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">Nama Customer</label>
                <h4>{{ $salesorder->customer->NamaCustomer }}</h4>
            </div>
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">Sales</label>
                <h4>{{ explode(' ', $salesorder->customer->employee->name)[0] }}</h4>
            </div>
        </div>
        
        <div class="modal-footer bg-gray-100">
            <div class="form-group col-md-12">
                <select class="form-control @error('shipping_status') is-invalid @enderror" name="shipping_status">
                    <option value="" selected disabled>-- Pilih Pengiriman --</option>
                    <option value="Pengiriman ke-1">Pengiriman ke-1</option>
                    <option value="Pengiriman ke-2">Pengiriman ke-2</option>
                    <option value="Pengiriman ke-3">Pengiriman ke-3</option>
                    <option value="Pengiriman ke-4">Pengiriman ke-4</option>
                    <option value="Pengiriman ke-5">Pengiriman ke-5</option>
                </select>
                @error('shipping_status')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <span class="badge bg-danger w-100 mb-3">Pastikan data yang Anda masukkan sudah benar!</span>
            <div class="d-flex justify-content-between" data-extra-toggle="confirmation">
                @php
                use Illuminate\Support\Str;
            
                $deliveryOrders = [];
                    // if (Str::contains($salesorder->invoice_no, 'RO')) {
                    //     $deliveryOrders[] = ['route' => 'store.DOReguler', 'label' => 'R-Offline'];
                    // }
                    // if (Str::contains($salesorder->invoice_no, 'HO')) {
                    //     $deliveryOrders[] = ['route' => 'store.DOHet', 'label' => 'H-Offline'];
                    // }
                    // if (Str::contains($salesorder->invoice_no, 'RS')) {
                    //     $deliveryOrders[] = ['route' => 'store.DOROnline', 'label' => 'R-Online'];
                    // }
                    // if (Str::contains($salesorder->invoice_no, 'HS')) {
                    //     $deliveryOrders[] = ['route' => 'store.DOHOnline', 'label' => 'H-Online'];
                    // }
                    if (Str::contains($salesorder->invoice_no, ['RO', 'SOR'])) {
                        $deliveryOrders[] = ['route' => 'store.DOReguler', 'label' => 'R-Offline'];
                    }
                    if (Str::contains($salesorder->invoice_no, ['HO', 'SOH'])) {
                        $deliveryOrders[] = ['route' => 'store.DOHet', 'label' => 'H-Offline'];
                    }
                    if (Str::contains($salesorder->invoice_no, ['RS', 'SORS'])) {
                        $deliveryOrders[] = ['route' => 'store.DOROnline', 'label' => 'R-Online'];
                    }
                    if (Str::contains($salesorder->invoice_no, ['HS', 'SOHS'])) {
                        $deliveryOrders[] = ['route' => 'store.DOHOnline', 'label' => 'H-Online'];
                    }
                @endphp

                {{-- @foreach ($deliveryOrders as $order)
                    <form action="{{ route($order['route']) }}" method="post" class="confirmation-form">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $salesorder->id }}">
                        <button type="button" class="btn bg-success me-3 confirm-button"><b>{{ $order['label'] }}</b></button>
                    </form>
                @endforeach --}}
                @foreach ($deliveryOrders as $order)
                    <form action="{{ route($order['route']) }}" method="post" class="confirmation-form">
                        @csrf
                        <input type="" name="order_id" value="{{ $salesorder->id }}">
                        <input type="" name="shipping_status" id="shipping_status_{{ $order['route'] }}">
                        <button type="submit" class="btn bg-success me-3 confirm-button" onclick="submitForm('{{ $order['route'] }}')">
                            <b>{{ $order['label'] }}</b>
                        </button>
                    </form>
                @endforeach
              
            </div>
        </div>
      </div>
    </div>
</div>