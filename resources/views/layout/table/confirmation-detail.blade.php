<table class="table nowrap">
    <thead>
        <tr>
            <th>Nama Produk</th>
            <th width="250px">Kategori</th>
            <th width="150px">Harga</th>
            <th width="150px">Jumlah</th>
            <th width="150px">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($content as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->category }}</td>
            <th class="text-end">Rp {{ number_format($item->price) }}</th>
            <th class="text-end">{{ number_format($item->qty) }}</th>
            <th class="text-end">Rp {{ number_format($item->subtotal) }}</th>
        </tr>
        @endforeach
    </tbody>
</table>