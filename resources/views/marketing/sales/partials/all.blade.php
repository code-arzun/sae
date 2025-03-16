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
    </div>
    <div class="row">
        @foreach ($sales as $salesrep)
        <div class="col-md-6 col-xl-3">
            <a class="nav-link" id="detail-tab-card-{{ $salesrep->id }}" data-bs-toggle="tab" href="#detail-{{ $salesrep->id }}" role="tab">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/') }}" alt="" class="img-fluid">
                        <h4 class="mb-2">{{ $salesrep->name }}</h4>
                        {{ $salesrep->position->name }}
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>