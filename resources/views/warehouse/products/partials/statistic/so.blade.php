<div class="dt-responsive table-responsive mb-3">
    <table class="table mb-0">
        <thead>
            <tr>
                <th colspan="2">Nama Produk</th>
                <th>Menunggu Persetujuan</th>
                <th>Belum Ada Pengiriman</th>
                <th>Sudah Ada Pengiriman</th>
                <th>Selesai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td width="150px"><img class="img-fluid" src="{{ $product->product_image ? asset($product->product_image) : asset(Storage::url('products/default.png')) }}" alt="{{ $product->product_name }}"></td>
                <td><a href="{{ route('products.show', $product->id) }}"><h5>{{ $product->product_name }}</h5></a>{{ $product->category->name }}</td>
                <!-- SO Diajukan -->
                <td class="text-center">
                    {{-- @if ($product->rekap_SOdiajukan = 0)
                        <h5 class="text-danger">{{ $product->rekap_SOdiajukan }}</h5>
                        @elseif ($product->rekap_SOdiajukan > 100)
                            <h5 class="text-success">{{ $product->rekap_SOdiajukan }}</h5>
                        @else
                            <h5 class="text-danger">{{ $product->rekap_SOdiajukan }}</h5>
                    @endif --}}
                    <h5>{{ $product->rekap_SOdiajukan }}</h5>
                </td>
                <!-- SO disetujui belum ada DO -->
                <td class="text-center">
                    @if ($product->rekap_SOdisetujui - $product->rekap_DOterpacking - $product->rekap_DOpengiriman - $product->rekap_DOterkirim > 0)
                        <h5 class="text-danger">{{ $product->rekap_SOdisetujui - $product->rekap_DOterpacking - $product->rekap_DOpengiriman - $product->rekap_DOterkirim }}</h5>
                    @else
                        <h5 class="text-success">{{ $product->rekap_SOdisetujui - $product->rekap_DOterpacking - $product->rekap_DOpengiriman - $product->rekap_DOterkirim }}</h5>
                    @endif
                </td>
                <!-- SO disetujui sudah ada DO-->
                <td class="text-center">
                    @if ($product->rekap_SOdisetujui - ($product->rekap_SOdisetujui - $product->rekap_DOterpacking - $product->rekap_DOpengiriman - $product->rekap_DOterkirim) > 0)
                        <h5 class="text-danger">{{ $product->rekap_SOdisetujui - ($product->rekap_SOdisetujui - $product->rekap_DOterpacking - $product->rekap_DOpengiriman - $product->rekap_DOterkirim) }}</h5>
                    @else
                        <h5 class="text-success">{{ $product->rekap_SOdisetujui - ($product->rekap_SOdisetujui - $product->rekap_DOterpacking - $product->rekap_DOpengiriman - $product->rekap_DOterkirim) }}</h5>
                    @endif
                </td>                
            </tr>

            @empty
                @include('layout.partials.alert-danger')
            @endforelse
        </tbody>
    </table>
</div>