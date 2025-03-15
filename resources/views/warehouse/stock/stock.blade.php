@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @if (session()->has('success'))
                <div class="alert text-white bg-success" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Stok Produk</h4>
                    {{-- <p class="mb-0">A stock product dashboard lets you easily gather and visualize stock product data from optimizing <br>
                        the stock product experience, ensuring stock product retention. </p> --}}
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            {{-- <form action="{{ route('order.stockManage') }}" method="get"> --}}
            <form action="{{ route('delivery.stockManage') }}" method="get">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="form-group row">
                        <label for="row" class="col-sm-3 align-self-center">Row:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="row">
                                <option value="5" @if(request('row') == '5')selected="selected"@endif>5</option>
                                <option value="10" @if(request('row') == '10')selected="selected"@endif>10</option>
                                <option value="25" @if(request('row') == '25')selected="selected"@endif>25</option>
                                <option value="50" @if(request('row') == '50')selected="selected"@endif>50</option>
                                <option value="100" @if(request('row') == '100')selected="selected"@endif>100</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3 align-self-center" for="search">Search:</label>
                        <div class="input-group col-sm-8">
                            <input type="text" id="search" class="form-control" name="search" placeholder="Search product" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text bg-primary"><i class="fa-solid fa-magnifying-glass font-size-20"></i></button>
                                {{-- <a href="{{ route('order.stockManage') }}" class="input-group-text bg-danger"><i class="fa-solid fa-trash"></i></a> --}}
                                <a href="{{ route('delivery.stockManage') }}" class="input-group-text bg-danger"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead class="bg-white text-uppercase text-center">
                        <tr class="ligth ligth-data">
                            <th>No.</th>
                            <th>@sortablelink('product_name', 'Nama Produk')</th>
                            <th>@sortablelink('category.name', 'Kategori')</th>
                            <th>@sortablelink('selling_price', 'Harga')</th>
                            <th>@sortablelink('product_store', 'Stok')</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @forelse ($products as $product)
                        <tr>
                            <td>{{ (($products->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>
                                <img class="avatar-60 rounded me-3" src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.webp') }}">
                                <b>{{ $product->product_name }}</b>
                            </td>
                            <td>{{ $product->category->name }}</td>
                            <td>Rp {{ number_format($product->selling_price) }}</td>
                            <td class="text-center">
                                @if ($product->product_store > 100)
                                    <span class="btn bg-success">{{ $product->product_store }}</span>
                                @elseif ($product->product_store >= 50 && $product->product_store <= 99)
                                    <span class="btn bg-warning">{{ $product->product_store }}</span>
                                @else
                                    <span class="btn bg-danger">{{ $product->product_store }}</span>
                                @endif
                            </td>
                            <td>{{ $product->category->productunit->name }}</td>
                        </tr>

                        @empty
                        <div class="alert text-white bg-danger" role="alert">
                            <div class="iq-alert-text">Data not Found.</div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="ri-close-line"></i>
                            </button>
                        </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $products->links() }}
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
