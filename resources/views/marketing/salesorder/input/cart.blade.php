<table class="table">
    <thead>
        <tr>
            <th width="50px">#</th>
            <th>Nama Produk</th>
            <th width="120px">Harga</th>
            <th width="50px">Jumlah</th>
            <th width="150px">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productItem as $item)
        <tr>
            <td class="text-center">
                <a href="{{ route('inputso.deleteCart', $item->rowId) }}" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="left" title="Hapus">
                    <i class="ti ti-trash"></i>
                </a>
            </td>
            <td>
                <h5 class="mb-0">{{ $item->name }}</h5>
                <span class="text-secondary">{{ $item->category }}</span>
            </td>
            <td class="accounting price">{{ number_format($item->price) }}</td>
            <form action="{{ route('inputso.updateCart', $item->rowId) }}" method="POST">
            <td>
                    @csrf
                    <div class="input-group">
                        <input type="number" class="form-control text-center" style="width:100px" name="qty" required
                            value="{{ old('qty', $item->qty) }}" onblur="this.form.submit()">
                    </div>
                </td>
            </form>
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
    <!-- Diskon -->
    <form action="{{ route('inputso.confirmation') }}" method="POST">
        @csrf
        <tr>
            <th class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Gunakan titik (.) sebagai pemisah!">Diskon (%)</th>
            <th>
                <div class="input-group">
                    <input type="number" step="0.01" data-bs-toggle="tooltip" data-bs-placement="top" title="Gunakan titik (.) sebagai pemisah!"
                        onclick="calculateDiscount()" onkeyup="calculateDiscount()" class="form-control text-center"
                        id="discount_percent" name="discount_percent" value="{{ old('discount_percent', 0) }}">
                </div>
            </th>
            <th>
                <input type="number" class="form-control text-center bg-white" id="discount_rp" name="discount_rp" value="{{ old('discount_rp', 0) }}" readonly>
            </th>
        </tr>
    <!-- Grand Total -->
    <tr>
        <th colspan="2" class="text-end">Grand Total</th>
        <th>
            <input type="number" class="form-control bg-white text-center" id="grandtotal" name="grandtotal" value="{{ old('grandtotal', 0) }}" readonly>
        </th>
        
    </tr>
</table>

<div class="col-md-12 mt-3">
    <div class="form-group">
        <label for="customer_id">Pilih Customer</label>
        <select class="form-control select2" id="customer_id" name="customer_id" required>
            <option selected="" disabled="">-- Customer --</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}" 
                        data-nama-lembaga="{{ $customer->NamaLembaga }}"
                        data-nama-customer="{{ $customer->NamaCustomer }}"
                        data-jabatan="{{ $customer->Jabatan }}"
                        @if (auth()->user()->hasAnyRole('Super Admin', 'Manajer Marketing', 'Admin'))
                        data-employee-name="{{ $customer->employee->name }}"
                        @endif>
                    {{ $customer->NamaLembaga }} | {{ $customer->NamaCustomer }} - {{ $customer->Jabatan }}
                    @if (auth()->user()->hasAnyRole('Super Admin', 'Manajer Marketing', 'Admin'))
                    | {{ $customer->employee->name }}
                    @endif
                </option>
            @endforeach
        </select>
    </div>
    @error('customer_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="col-md-12 mt-3">
    <button type="submit" class="btn btn-success w-100"><b>Buat Sales Order</b></button>
</div>
</form>