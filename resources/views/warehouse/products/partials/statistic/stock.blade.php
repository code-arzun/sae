<div class="dt-responsive table-responsive mb-3">
    <table class="table mb-0">
        <thead>
            <tr>
                <th colspan="2">Nama Produk</th>
                <th>Stok</th>
                <th>Stok dibutuhkan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td width="150px"><img class="img-fluid" src="{{ $product->product_image ? asset($product->product_image) : asset(Storage::url('products/default.png')) }}" alt="{{ $product->product_name }}"></td>
                <td><a href="{{ route('products.show', $product->id) }}"><h5>{{ $product->product_name }}</h5></a>{{ $product->category->name }}</td>
                <td class="text-center">
                    @if ($product->product_store >= 100)
                        <h5 class="text-success">{{ $product->product_store }}</h5>
                    @elseif ($product->product_store >= 50 && $product->product_store <= 99)
                        <h5 class="text-warning">{{ $product->product_store }}</h5>
                    @else
                        <h5 class="text-danger">{{ $product->product_store }}</h5>
                    @endif
                    {{-- <h5 class="ml-1">{{ $product->category->productunit->name }}</h5> --}}
                </td>
                <!-- Stok dibutuhkan -->
                <td class="text-center">
                    @if ($product->stok_dibutuhkan > 0)
                        <h5 class="text-danger">{{ $product->stok_dibutuhkan }}</h5>
                    @else
                    @endif
                    {{-- @if ($product->rekap_SOdisetujui - ($product->rekap_DOterpacking + $product->rekap_DOpengiriman + $product->rekap_DOterkirim + $product->product_store) > 0)
                        <h5 class="text-danger">{{ $product->rekap_SOdisetujui - ($product->rekap_DOterpacking + $product->rekap_DOpengiriman + $product->rekap_DOterkirim + $product->product_store) }}</h5>
                    @else
                    @endif --}}
                </td>
            </tr>

            @empty
                @include('layout.partials.alert-danger')
            @endforelse
        </tbody>
    </table>
</div>