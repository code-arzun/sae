<div class="dt-responsive table-responsive mb-3">
    <table class="table mb-0">
        <thead>
            <tr>
                <th colspan="2">Nama Produk</th>
                <th width="200px">Kategori</th>
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Staf Publishing', 'Admin Publishing', 'Manajer Publishing']))
                <th width="200px">Penulis</th>
                @endif
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Adming Gudang', 'Sales', 'Manajer Marketing']))
                <th width="150px">Penerbit</th>
                @endif
                <th width="100px">Harga 
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Admin Gudang', 'Manajer Marketing']))
                    Jual
                </th>
                <th width="100px">Status</th>
                @endif
                <th width="120px">Stok</th>
                <th width="100px">#</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td width="150px"><img class="img-fluid" src="{{ $product->product_image ? asset($product->product_image) : asset(Storage::url('products/default.png')) }}" alt="{{ $product->product_name }}"></td>
                {{-- <td><b>{{ $product->product_name }}</b></td> --}}
                <td><a href="{{ route('products.show', $product->id) }}"><h5>{{ $product->product_name }}</h5></a></td>
                <td>{{ $product->category->name }}</td>
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Staf Publishing', 'Admin Publishing', 'Manajer Publishing']))
                <td>
                    @if ($product->writer)
                        <b>{{ $product->writer->NamaPenulis }}</b>
                    @else
                        -
                    @endif
                </td>
                @endif
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Adming Gudang', 'Sales', 'Manajer Marketing']))
                <td>
                    @if ($product->publisher_id)
                        <b>{{ $product->publisher->NamaPenerbit }}</b>
                    @else
                        -
                    @endif
                </td>
                <td class="accounting price">{{ number_format($product->selling_price) }}</td>
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Admin Gudang']))
                <td class="text-center">
                    @if ($product->expire_date > Carbon\Carbon::now()->format('Y-m-d'))
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-danger">Tidak Aktif</span>
                    @endif
                </td>
                @endif
                @endif
                <td class="text-end">
                    <b>{{ $product->product_store }}</b> {{ $product->category->productunit->name }}
                </td>
                <td class="text-center">
                    <div class="d-flex align-items-center justify-content-center">
                        <a class="badge bg-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail"
                            href="{{ route('products.show', $product->id) }}"><i class="ti ti-eye"></i>
                        </a>
                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Admin Gudang']))
                        <!-- Edit -->
                        <a href="#" class="badge bg-warning me-1" data-bs-toggle="modal" data-bs-target="#editProduk{{ $product->id }}"><i class="ti ti-edit"></i></a>
                        @include('warehouse.products.edit')
                        <!-- Delete -->
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="margin-bottom: 5px">
                            @method('delete')
                            @csrf
                                <button type="submit" class="badge bg-danger" onclick="return confirm('Are you sure you want to delete this record?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="ti ti-trash"></i></button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>

            @empty
                @include('layout.partials.alert-danger')
            @endforelse
        </tbody>
    </table>
</div>
{{ $products->links() }}