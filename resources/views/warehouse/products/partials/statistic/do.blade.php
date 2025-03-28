<div class="dt-responsive table-responsive mb-3">
    <table class="table mb-0">
        <thead>
            <tr>
                <th colspan="2">Nama Produk</th>
                <th>Terpacking</th>
                <th>Dalam Pengiriman Pengiriman</th>
                <th>Terkirim</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td width="150px"><img class="img-fluid" src="{{ $product->product_image ? asset($product->product_image) : asset(Storage::url('products/default.png')) }}" alt="{{ $product->product_name }}"></td>
                <td><a href="{{ route('products.show', $product->id) }}"><h5>{{ $product->product_name }}</h5></a>{{ $product->category->name }}</td>
                <!-- DO terpacking -->
                <td class="text-center">
                    @if ($product->rekap_DOterpacking > 0)
                        <h5 class="text-danger">{{ $product->rekap_DOterpacking }}</h5>
                    @else
                        <h5 class="text-success">{{ $product->rekap_DOterpacking }}</h5>
                    @endif
                </td>
                <!-- DO dalam pengiriman -->
                <td class="text-center">
                    @if ($product->rekap_DOpengiriman > 0)
                        <h5 class="text-danger">{{ $product->rekap_DOpengiriman }}</h5>
                    @else
                        <h5 class="text-success">{{ $product->rekap_DOpengiriman }}</h5>
                    @endif
                </td>
                <!-- DO terkirim -->
                <td class="text-center">
                    @if ($product->rekap_DOterkirim > 0)
                        <h5 class="text-danger">{{ $product->rekap_DOterkirim }}</h5>
                    @else
                        <h5 class="text-success">{{ $product->rekap_DOterkirim }}</h5>
                    @endif
                </td>
            </tr>

            @empty
                @include('layout.partials.alert-danger')
            @endforelse
        </tbody>
    </table>
</div>