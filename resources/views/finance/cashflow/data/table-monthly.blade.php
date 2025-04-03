<ul class="nav nav-pills mb-3" id="monthly" role="tablist">
    @foreach ($monthlyCashflows as $month => $cashflows)
    <li class="nav-item me-3">
        <a class="nav-link @if ($loop->first) active @endif" id="pills-annual-{{ $month }}-tab" 
            data-bs-toggle="pill" href="#pills-annual-{{ $month }}" 
            role="tab" aria-controls="pills-annual-{{ $month }}" 
            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
            {{ Carbon\Carbon::parse($month)->translatedformat('F Y') }}
        </a>
    </li>
    @endforeach
</ul>

<div class="tab-content" id="pills-tabContent">
    @foreach ($monthlyCashflows as $month => $cashflows)
    <div class="tab-pane fade @if ($loop->first) show active @endif" id="pills-annual-{{ $month }}" 
        role="tabpanel" aria-labelledby="pills-annual-{{ $month }}-tab">
        @include('finance.cashflow.data.table', ['cashflows' => $cashflows])
    </div>
    @endforeach
</div>