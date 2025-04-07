<ul class="nav nav-pills mb-3" id="productStats" role="tablist">
    <li class="nav-item me-3">
        <a class="nav-link active" id="pills-stock-tab" data-bs-toggle="pill" href="#pills-stock" role="tab" aria-controls="pills-stock" aria-selected="true">Stok</a>
    </li>
    <li class="nav-item me-3">
        <a class="nav-link" id="pills-so-tab" data-bs-toggle="pill" href="#pills-so" role="tab" aria-controls="pills-so" aria-selected="false">Sales Order</a>
    </li>
    <li class="nav-item me-3">
        <a class="nav-link" id="pills-do-tab" data-bs-toggle="pill" href="#pills-do" role="tab" aria-controls="pills-do" aria-selected="false">Delivery Order</a>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
    <!-- Stock -->
    <div class="tab-pane fade show active" id="pills-stock" role="tabpanel" aria-labelledby="pills-stock-tab">
        <div class="row">
            @include('warehouse.products.partials.statistic.stock')
        </div>
    </div>
    <!-- Sales Order -->
    <div class="tab-pane fade" id="pills-so" role="tabpanel" aria-labelledby="pills-so-tab">
        <div class="row">
            @include('warehouse.products.partials.statistic.so')
        </div>
    </div>
    <!-- Ddelivery Order -->
    <div class="tab-pane fade" id="pills-do" role="tabpanel" aria-labelledby="pills-do-tab">
        <div class="row">
            @include('warehouse.products.partials.statistic.do')
        </div>
    </div>
</div>


{{ $products->links() }}