<div id="save" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="saveTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="saveTitle">Simpan Sales Order Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-flex justify-content-between">
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">Tanggal Pemesanan</label>
                
            </div>
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">Nama Lembaga</label>
                <h4>{{ $customer->NamaLembaga }}</h4>
            </div>
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">Nama Customer</label>
                <h4>{{ $customer->NamaCustomer }}</h4>
            </div>
            <div class="d-flex flex-column align-items-center text-center">
                <label class="text-secondary mb-2">Sales</label>
                <h4>{{ explode(' ', $customer->employee->name)[0] }}</h4>
            </div>
        </div>
        
        <div class="modal-footer bg-gray-100">
            <span class="badge bg-danger w-100 mb-3">Pastikan data yang Anda masukkan sudah benar!</span>
            <div class="d-flex justify-content-between" data-extra-toggle="confirmation">
                @php
                    $salesOrders = [
                        ['route' => 'store.SOReguler', 'label' => 'Reguler'],
                        ['route' => 'store.SOHet', 'label' => 'HET'],
                        ['route' => 'store.SOROnline', 'label' => 'Reguler SIPLah'],
                        ['route' => 'store.SOHOnline', 'label' => 'HET SIPLah']
                        // ['route' => 'store.SOReguler', 'label' => 'R-Offline'],
                        // ['route' => 'store.SOHet', 'label' => 'H-Offfline'],
                        // ['route' => 'store.SOROnline', 'label' => 'R-Online'],
                        // ['route' => 'store.SOHOnline', 'label' => 'H-Online']
                    ];
                @endphp

                @foreach ($salesOrders as $order)
                    @php
                        $btnClass = Str::contains($order['label'], 'SIPLah') ? 'btn-info' : 'btn-warning';
                    @endphp

                    <form action="{{ route($order['route']) }}" method="post" class="confirmation-form">
                        @csrf
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        <input type="hidden" name="discount_percent" value="{{ $discount_percent }}">
                        <input type="hidden" name="discount_rp" value="{{ $discount_rp }}">
                        <input type="hidden" name="grandtotal" value="{{ $grandtotal }}">
                        <button type="submit" class="btn {{ $btnClass }} me-3 confirm-button"><b>{{ $order['label'] }}</b></button>
                    </form>
                @endforeach
            </div>
        </div>
      </div>
    </div>
</div>