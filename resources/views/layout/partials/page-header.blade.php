<div class="d-flex justify-content-between mb-3">
    <!-- Left -->
    <div>
        <!-- Title -->
        <h2>{{ $title }}</h2>
        <!-- Breadcrumb -->
        @include('layout.partials.breadcrumb')
    </div>
    <!-- Right -->
    <div>
        @yield('action-button')
    </div>
</div>