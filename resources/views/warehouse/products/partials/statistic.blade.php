
<ul class="nav nav-pills mb-3" id="productStats" role="tablist">
    <a class="btn btn-outline-primary me-3" data-bs-toggle="collapse" href="#stock" aria-expanded="false">Stok</a>
    <a class="btn btn-outline-primary me-3" data-bs-toggle="collapse" href="#so" aria-expanded="false">Sales Order</a>
    <a class="btn btn-outline-primary" data-bs-toggle="collapse" href="#do" aria-expanded="false">Delivery Order</a>
</ul>

<div class="dt-responsive table-responsive mb-3">
    <table class="table table-bordered mb-0">
        <thead>
            <tr>
                <th rowspan="2" colspan="2">Nama Produk</th>
                <th rowspan="2" class="collapse show" id="stock" width="120px">Stok</th>
                <th rowspan="2" class="collapse" id="so">SO diajukan</th>
                <th colspan="2" class="collapse" id="so">SO disetujui</th>
                {{-- <th>SO disetujui</th> --}}
                <th rowspan="2" class="collapse show" id="stock" >Stok dibutuhkan</th>
                <th rowspan="2"  class="collapse" id="do">DO terpacking</th>
                <th rowspan="2"  class="collapse" id="do">DO dalam pengiriman</th>
                <th rowspan="2"  class="collapse" id="do">DO terkirim</th>
            </tr>
            <tr>
                <th width="50px" class="collapse" id="so">Belum ada pengiriman</th>
                <th width="50px" class="collapse" id="so">Sudah ada pengiriman</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td width="150px"><img class="img-fluid" src="{{ $product->product_image ? asset($product->product_image) : asset(Storage::url('products/default.png')) }}" alt="{{ $product->product_name }}"></td>
                <td><a href="{{ route('products.show', $product->id) }}"><h5>{{ $product->product_name }}</h5></a>{{ $product->category->name }}</td>
                <td class="text-center collapse show" id="stock">
                    @if ($product->product_store >= 100)
                        <h5 class="text-success">{{ $product->product_store }}</h5>
                    @elseif ($product->product_store >= 50 && $product->product_store <= 99)
                        <h5 class="text-warning">{{ $product->product_store }}</h5>
                    @else
                        <h5 class="text-danger">{{ $product->product_store }}</h5>
                    @endif
                    {{-- <h5 class="ml-1">{{ $product->category->productunit->name }}</h5> --}}
                </td>
                <!-- SO Diajukan -->
                <td class="text-center collapse" id="so">
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
                <td class="text-center collapse" id="so">
                    @if ($product->rekap_SOdisetujui - $product->rekap_DOterpacking - $product->rekap_DOpengiriman - $product->rekap_DOterkirim > 0)
                        <h5 class="text-danger">{{ $product->rekap_SOdisetujui - $product->rekap_DOterpacking - $product->rekap_DOpengiriman - $product->rekap_DOterkirim }}</h5>
                    @else
                        <h5 class="text-success">{{ $product->rekap_SOdisetujui - $product->rekap_DOterpacking - $product->rekap_DOpengiriman - $product->rekap_DOterkirim }}</h5>
                    @endif
                </td>
                <!-- SO disetujui sudah ada DO-->
                <td class="text-center collapse" id="so">
                    @if ($product->rekap_SOdisetujui - ($product->rekap_SOdisetujui - $product->rekap_DOterpacking - $product->rekap_DOpengiriman - $product->rekap_DOterkirim) > 0)
                        <h5 class="text-danger">{{ $product->rekap_SOdisetujui - ($product->rekap_SOdisetujui - $product->rekap_DOterpacking - $product->rekap_DOpengiriman - $product->rekap_DOterkirim) }}</h5>
                    @else
                        <h5 class="text-success">{{ $product->rekap_SOdisetujui - ($product->rekap_SOdisetujui - $product->rekap_DOterpacking - $product->rekap_DOpengiriman - $product->rekap_DOterkirim) }}</h5>
                    @endif
                </td>
                <!-- Stok dibutuhkan -->
                <td class="text-center collapse show" id="stock" >
                    @if ($product->stok_dibutuhkan > 0)
                        <h5 class="text-danger">{{ $product->stok_dibutuhkan }}</h5>
                    @else
                    @endif
                    {{-- @if ($product->rekap_SOdisetujui - ($product->rekap_DOterpacking + $product->rekap_DOpengiriman + $product->rekap_DOterkirim + $product->product_store) > 0)
                        <h5 class="text-danger">{{ $product->rekap_SOdisetujui - ($product->rekap_DOterpacking + $product->rekap_DOpengiriman + $product->rekap_DOterkirim + $product->product_store) }}</h5>
                    @else
                    @endif --}}
                </td>
                <!-- DO terpacking -->
                <td class="text-center collapse" id="do">
                    @if ($product->rekap_DOterpacking > 0)
                        <h5 class="text-danger">{{ $product->rekap_DOterpacking }}</h5>
                    @else
                        <h5 class="text-success">{{ $product->rekap_DOterpacking }}</h5>
                    @endif
                </td>
                <!-- DO dalam pengiriman -->
                <td class="text-center collapse" id="do">
                    @if ($product->rekap_DOpengiriman > 0)
                        <h5 class="text-danger">{{ $product->rekap_DOpengiriman }}</h5>
                    @else
                        <h5 class="text-success">{{ $product->rekap_DOpengiriman }}</h5>
                    @endif
                </td>
                <!-- DO terkirim -->
                <td class="text-center collapse" id="do">
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
{{ $products->links() }}