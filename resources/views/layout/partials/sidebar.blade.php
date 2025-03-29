{{-- <nav class="pc-sidebar pc-sidebar-hide"> --}}
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="{{ route('dashboard') }}" class="b-brand text-primary">
        <!-- Logo -->
        <img src="{{ asset('assets/images/logo.png') }}" class="logo" height="50px" alt="logo">
      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-item">
          <a href="{{ route('dashboard') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{ route('myattendance') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-calendar-plus"></i></span>
            <span class="pc-mtext">Absensi</span>
          </a>
        </li>

        <!-- Marketing -->
        @if (auth()->user()->can('customer'))
        <li class="pc-item pc-caption">
          <label>Marketing</label>
          <i class="ti ti-dashboard"></i>
        </li>
        @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
          <li class="pc-item">
            <a href="{{ route('sales') }}" class="pc-link">
              <span class="pc-micon"><i class="ti ti-users"></i></span>
              <span class="pc-mtext">Sales</span>
            </a>
          </li>
        @endif
        @if (auth()->user()->can('customer'))
        <li class="pc-item">
          <a href="{{ route('customers.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-users"></i></span>
            <span class="pc-mtext">Customer</span>
          </a>
        </li>
        @endif
        <li class="pc-item">
          <a href="{{ route('so.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-color-swatch"></i></span>
            <span class="pc-mtext">Sales Order</span>
          </a>
        </li>
        @endif

        {{-- @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
        <li class="pc-item pc-caption">
          <label>Retail</label>
          <i class="ti ti-dashboard"></i>
        </li>
        <li class="pc-item">
          <a href="{{ route('customers.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-users"></i></span>
            <span class="pc-mtext">Sales</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{ route('customers.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-users"></i></span>
            <span class="pc-mtext">Customer</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{ route('so.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-color-swatch"></i></span>
            <span class="pc-mtext">Sales Order</span>
          </a>
        </li>
        @endif --}}

        @if (auth()->user()->can('do'))
        <li class="pc-item pc-caption">
          <label>Gudang</label>
          <i class="ti ti-news"></i>
        </li>
        <li class="pc-item">
          <a href="{{ route('do.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-lock"></i></span>
            <span class="pc-mtext">Delivery Order</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{ route('retur.all') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
            <span class="pc-mtext">Retur</span>
          </a>
        </li>
        @if (auth()->user()->can('input.do'))
        <li class="pc-item">
          <a href="{{ route('stock.all') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-lock"></i></span>
            <span class="pc-mtext">Stok</span>
          </a>
        </li>
        @endif
        <li class="pc-item">
          <a href="{{ route('products.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
            <span class="pc-mtext">Produk</span>
          </a>
        </li>
        @endif

        @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Finance']))
        <li class="pc-item pc-caption">
          <label>Finance</label>
          <i class="ti ti-report-money"></i>
        </li>
        <li class="pc-item">
          <a href="{{ route('customers.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-users"></i></span>
            <span class="pc-mtext">Kas</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{ route('collection.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-report-money"></i></span>
            <span class="pc-mtext">Collection</span>
          </a>
        </li>
        @endif
        
        {{-- <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-truck-delivery"></i></span><span class="pc-mtext">Delivery Order</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('input.do') }}">Input</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('do.index') }}">Data</a></li>
          </ul>
        </li> --}}

        {{-- <li class="pc-item pc-caption">
          <label>Other</label>
          <i class="ti ti-brand-chrome"></i>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-menu"></i></span><span class="pc-mtext">Menu
              levels</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="#!">Level 2.1</a></li>
            <li class="pc-item pc-hasmenu">
              <a href="#!" class="pc-link">Level 2.2<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
              <ul class="pc-submenu">
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                <li class="pc-item pc-hasmenu">
                  <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                  <ul class="pc-submenu">
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="pc-item pc-hasmenu">
              <a href="#!" class="pc-link">Level 2.3<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
              <ul class="pc-submenu">
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                <li class="pc-item pc-hasmenu">
                  <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                  <ul class="pc-submenu">
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="pc-item">
          <a href="{{ route('myattendance') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-brand-chrome"></i></span>
            <span class="pc-mtext">Sample page</span>
          </a>
        </li> --}}
      </ul>
    </div>
  </div>
</nav>