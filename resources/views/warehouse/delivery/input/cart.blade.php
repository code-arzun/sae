<!-- Detail Pesanan -->
<table class="table nowrap">
    <thead>
        <tr class="text-center">
            <th width="50px">#</th>
            <th>Nama Produk</th>
            <th width="150px">Kategori</th>
            <th width="100px">Harga</th>
            <th width="50px">Jumlah</th>
            <th width="150px">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productItem as $item)
        <tr>
            <td class="text-center">
                <a href="{{ route('inputdo.deleteCart', $item->rowId) }}" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                    <i class="ti ti-trash"></i>
                </a>
            </td>
            <td data-bs-toggle="tooltip" data-bs-placement="top" title="Rp {{ number_format($item->price) }}">
                <b>{{ $item->name }}</b> <br>
            </td>
            <td class="text-secondary">{{ $item->category }}</td>
            <td class="accounting price">{{ number_format($item->price) }}</td>
            <td>
                <form action="{{ route('inputdo.updateCart', $item->rowId) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="number" class="form-control text-center" style="width:100px" name="qty" required
                            value="{{ old('qty', $item->qty) }}" 
                            onblur="validateQuantity(this)">
                    </div>
                </form>
            </td>
            <td class="accounting price">{{ number_format($item->subtotal) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
 <!-- Total -->
<table class="table nowrap">
    <tr>
        <th>
            <div class="d-flex justify-content-start">
                <span class="me-3">Total Item</span>
                <span class="badge bg-info">{{ number_format(count(Cart::content())) }}</span>
            </div>
        </th>
        <th>
            <div class="d-flex justify-content-center">
                <span class="me-3">Total Barang</span>
                <span class="badge bg-warning">{{ number_format(Cart::count()) }}</span>
            </div>
        </th>
        <th>
            <div class="d-flex justify-content-end">
                <span class="me-3">Subtotal</span>
                <span class="badge bg-success">Rp {{ number_format(Cart::subtotal()) }}</span>
                <span id="subtotal" hidden>{{ Cart::subtotal() }}</span>
            </div>
        </th>
    </tr>
</table>

<form action="{{ route('inputdo.confirmation') }}" method="POST">
    @csrf
    <div class="row mt-3">
        {{-- <div class="form-group col-md-3">
            <label for="order_date">Tanggal Pemesanan</label>
            <input id="order_date" class="form-control @error('order_date') is-invalid @enderror" name="order_date" value="{{ old('order_date') }}" />
            @error('order_date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div> --}}
        <!-- SO -->
        <div class="form-group col-md" hidden>
            <label for="order_id">Sales Order</label>
            <select class="form-control order_id" name="order_id">
                <option selected="" disabled="">-- Pilih SO --</option>
                @foreach ($salesorders as $salesorder)
                    <option value="{{ $salesorder->id }}" {{ request('order_id') == $salesorder->id ? 'selected' : '' }}>
                        {{ $salesorder->invoice_no }} | {{ $salesorder->customer->NamaLembaga }} - 
                        {{ $salesorder->customer->NamaCustomer }} | Rp {{ $salesorder->sub_total }} | {{ $salesorder->customer->employee->name }}
                    </option>
                @endforeach
            </select>
            @error('order_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-success w-100">Buat Delivery Order</button>
        </div>
    </div>
</form>