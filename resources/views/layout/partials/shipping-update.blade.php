<form action="{{ route('so.shippingStatus') }}" method="POST" class="confirmation-form">
    @method('PUT')
    @csrf
    <input type="hidden" name="id" value="{{ $order->id }}">
    <input type="hidden" name="shipping_status" id="shipping_status_{{ $order->id }}">
    <div class="btn-group me-1">
        <a href="" class="badge bg-secondary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti ti-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Perbarui status pengiriman"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-left">
            <button type="submit" class="dropdown-item" onclick="setShippingStatus({{ $order->id }}, 'Belum ada pengiriman')">Belum ada pengiriman</button>
            <button type="submit" class="dropdown-item" onclick="setShippingStatus({{ $order->id }}, 'Pengiriman ke-1')">Pengiriman ke-1</button>
            <button type="submit" class="dropdown-item" onclick="setShippingStatus({{ $order->id }}, 'Pengiriman ke-2')">Pengiriman ke-2</button>
            <button type="submit" class="dropdown-item" onclick="setShippingStatus({{ $order->id }}, 'Pengiriman ke-3')">Pengiriman ke-3</button>
            <button type="submit" class="dropdown-item" onclick="setShippingStatus({{ $order->id }}, 'Pengiriman ke-4')">Pengiriman ke-4</button>
            <button type="submit" class="dropdown-item" onclick="setShippingStatus({{ $order->id }}, 'Pengiriman ke-5')">Pengiriman ke-5</button>
            <button type="submit" class="dropdown-item" onclick="setShippingStatus({{ $order->id }}, 'Pengiriman ke-6')">Pengiriman ke-6</button>
            <button type="submit" class="dropdown-item" onclick="setShippingStatus({{ $order->id }}, 'Pengiriman ke-7')">Pengiriman ke-7</button>
            <button type="submit" class="dropdown-item" onclick="setShippingStatus({{ $order->id }}, 'Terkirim')">Terkirim</button>
        </div>
    </div>
</form>