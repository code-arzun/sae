<ul class="nav nav-pills mb-3" id="yearly" role="tablist">
    @foreach ($annualCashflows as $year => $cashflows)
    <li class="nav-item me-3">
        <a class="nav-link @if ($loop->first) active @endif" id="pills-annual-{{ $year }}-tab" 
            data-bs-toggle="pill" href="#pills-annual-{{ $year }}" 
            role="tab" aria-controls="pills-annual-{{ $year }}" 
            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
            {{ $year }}
        </a>
    </li>
    @endforeach
</ul>

<div class="tab-content" id="pills-tabContent">
    @foreach ($annualCashflows as $year => $cashflows)
    <div class="tab-pane fade @if ($loop->first) show active @endif" id="pills-annual-{{ $year }}" 
        role="tabpanel" aria-labelledby="pills-annual-{{ $year }}-tab">
        @include('finance.cashflow.data.table', ['cashflows' => $cashflows])
    </div>
    @endforeach
</div>