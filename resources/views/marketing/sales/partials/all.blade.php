<div class="tab-pane fade show active" id="all" role="tabpanel">
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-200 text-muted">Total Sales</h6>
                    <h4 class="mb-0">
                        {{ $sales->count() }}
                        <span class="badge bg-light-primary border border-primary"></span>
                    </h4>
                </div>
                <div id="total-value-graph-1"></div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-100 text-muted">Total Sales</h6>
                    <h4 class="mb-0">
                        {{ $sales->count() }}
                        <span class="badge bg-light-primary border border-primary"></span>
                    </h4>
                </div>
                <div id="total-value-graph-1"></div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-200 text-muted">Total Sales</h6>
                    <h4 class="mb-0">
                        {{ $sales->count() }}
                        <span class="badge bg-light-primary border border-primary"></span>
                    </h4>
                </div>
                <div id="total-value-graph-1"></div>
            </div>
        </div>
    </div>
</div>