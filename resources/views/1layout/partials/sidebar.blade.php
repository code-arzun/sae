<div class="sidebar" id="sidebar">
    <div class="data-scrollbar" data-scroll="1">
        <nav class="sidebar-menu">
            {{-- <i class="btn btn-outline-danger fa fa-times d-flex align-items-center justify-content-end" aria-hidden="true" id="sidebar_close"></i> --}}
            <i class="fa fa-times d-flex" aria-hidden="true" id="sidebar_close"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Tutup Sidebar"></i>
            <ul id="sidebar-menu-toggle" class="menu">
            <!-- Beranda -->
                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}"><i class="fa fa-home" aria-hidden="true"></i><span>Beranda</span></a>
                </li>
            <!-- Absensi -->
                <li class="{{ Request::is('attendance/*') ? 'active' : '' }}">
                    <a href="{{ route('myattendance') }}"><i class="fa fa-hand-paper-o"></i><span>Absensi</span></a>
                    {{-- <a href="{{ route('attendance.create') }}"><i class="fa fa-hand-paper-o"></i><span>Absensi</span></a> --}}
                </li>
            <!-- Cashflow -->
                @if (auth()->user()->can('cashflow'))
                <li>
                    <a href="#cashflow" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fa fa-money "></i><span>Arus Kas</span>
                            <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                            </svg>
                    </a>
                    <ul id="cashflow" class="iq-submenu collapse" data-parent="#sidebar-menu-toggle">
                        <!-- Pengeluaran -->
                        <li>
                            <a href="#expense" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                                <i class="fa-solid fa-money-bill-1-wave"></i><span class="">Pengeluaran</span>
                                <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="expense" class="iq-submenu collapse" data-parent="#cashflow">
                                <li class="{{ Request::is('cashflow/input/expense') ? 'active' : '' }}">
                                    <a href="{{ route('input.expense') }}"><i class="fa-solid fa-arrow-right"></i><span>Input Pengeluaran</span></a>
                                </li>
                                <li class="{{ Request::is('cashflow/expense') ? 'active' : '' }}">
                                    <a href="{{ route('expense.index') }}"><i class="fa-solid fa-arrow-right"></i><span>Daftar Pengeluaran</span></a>
                                </li>
                            </ul>
                        </li>
                        <!-- Pemasukan -->
                        <li>
                            <a href="#income" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                                <i class="fa-solid fa-money-bill-1-wave"></i><span class="">Pemasukan</span>
                                <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="income" class="iq-submenu collapse" data-parent="#cashflow">
                                <li class="{{ Request::is('cashflow/input/income') ? 'active' : '' }}">
                                    <a href="{{ route('input.income') }}"><i class="fa-solid fa-arrow-right"></i><span>Input Pemasukan</span></a>
                                </li>
                                <li class="{{ Request::is('cashflow/income') ? 'active' : '' }}">
                                    <a href="{{ route('income.index') }}"><i class="fa-solid fa-arrow-right"></i><span>Daftar Pemasukan</span></a>
                                </li>
                            </ul>
                        </li>
                        <!-- Keterangan -->
                        <li>
                            <a href="#cashflowcategory" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                                <i class="fa fa-cog" aria-hidden="true"></i>
                                <span class="">Keterangan</span>
                                <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline>
                                    <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="cashflowcategory" class="iq-submenu collapse" data-parent="#cashflow">
                                <li class="{{ Request::is('cashflow/type*') ? 'active' : '' }}">
                                    <a href="{{ route('type.index') }}"><i class="fa-solid fa-arrow-right"></i><span>Jenis Transaksi</span></a>
                                </li>
                                <li class="{{ Request::is('cashflow/category*') ? 'active' : '' }}">
                                    <a href="{{ route('category.index') }}"><i class="fa-solid fa-arrow-right"></i><span>Kategori</span></a>
                                </li>
                                <li class="{{ Request::is('cashflow/detail*') ? 'active' : '' }}">
                                    <a href="{{ route('detail.index') }}"><i class="fa-solid fa-arrow-right"></i><span>Keterangan</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                @endif
            <!-- Marketing -->
                @if (auth()->user()->can('input.do'))
                <li>
                    <a href="#marketing" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-truck "></i><span>Marketing</span>
                        <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="marketing" class="iq-submenu collapse" data-parent="#sidebar-menu-toggle">
                    @endif
                        <!-- Customer -->
                        @if (auth()->user()->can('customer'))
                            <li class="{{ Request::is('customers*') ? 'active' : '' }}">
                                <a href="{{ route('customers.index') }}" class="svg-icon"><i class="fa-solid fa-users"></i><span class="">Data Customer</span></a>
                            </li>
                        @endif
                        <!-- Sales Order -->
                        @if (auth()->user()->can('so'))
                            <li>
                                <a href="#salesorder" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                                    <i class="fa-solid fa-cart-shopping"></i><span class="">Sales Order</span>
                                    <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                    </svg>
                                </a>
                                <ul id="salesorder" class="iq-submenu collapse">
                                    @if (auth()->user()->can('input.so'))
                                    <li class="{{ Request::is('input/so*') ? 'active' : '' }}">
                                        <a href="{{ route('input.so') }}" class="svg-icon"><i class="fa-solid fa-cart-shopping"></i><span>Input SO</span></a>
                                    </li>
                                    @endif
                                    @if (auth()->user()->can('so'))
                                    <li class="{{ Request::is('so*') ? 'active' : '' }}">
                                        <a href="{{ route('so.index') }}" class="svg-icon"><i class="fa-solid fa-basket-shopping"></i><span>Data SO</span></a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        
                        @if (auth()->user()->can('input.do'))
                    </ul>
                </li>
                @endif
            <!-- Gudang -->
                @if (auth()->user()->can('input.do'))
                <li>
                    <a href="#gudang" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-warehouse"></i><span>Gudang</span>
                        <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    @endif
                    @if (auth()->user()->can('input.do'))
                    <ul id="gudang" class="iq-submenu collapse" data-parent="#sidebar-menu-toggle">
                        @endif
                        @if (auth()->user()->can('penyiapan'))
                            <li class="{{ Request::is('penyiapan-produk') ? 'active' : '' }}">
                                <a href="{{ route('do.penyiapanProduk') }}"><i class="fa-solid fa-file"></i><span class="">Penyiapan Produk</span></a>
                            </li>
                        @endif
                        <!-- Delivery Order -->
                        @if (auth()->user()->can('input.do'))
                        <li>
                            <a href="#deliveryorder" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                                <i class="fa-solid fa-cart-shopping"></i><span class="">Delivery Order</span>
                                <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="deliveryorder" class="iq-submenu collapse" data-parent="#gudang">
                                @endif
                                @if (auth()->user()->can('input.do'))
                                    <li class="{{ Request::is('do/input') ? 'active' : '' }}">
                                        <a href="{{ route('input.do') }}" class="svg-icon"><i class="fa-solid fa-upload"></i><span class="">Input DO</span></a>
                                    </li>
                                @endif
                                @if (auth()->user()->can('do'))
                                    <li class="{{ Request::is('do*') ? 'active' : '' }}">
                                        <a href="{{ route('do.all') }}"><i class="fa-solid fa-truck"></i><span>Data DO</span></a>
                                    </li>
                                @endif
                                @if (auth()->user()->can('input.do'))
                            </ul>
                        </li>
                        @endif
                        <!-- Retur Order -->
                        @if (auth()->user()->can('input.retur'))
                        <li>
                            <a href="#retur" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                                <i class="fa-solid fa-cart-shopping"></i><span class="">Retur</span>
                                <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            @endif
                            @if (auth()->user()->can('input.retur'))
                            <ul id="retur" class="iq-submenu collapse" data-parent="#gudang">
                                <li class="{{ Request::is('input*') ? 'active' : '' }}">
                                    <a href="{{ route('input.retur') }}" class="svg-icon"><i class="fa-solid fa-upload"></i><span class="">Input Retur</span></a>
                                </li>
                                @endif
                                @if (auth()->user()->can('retur'))
                                <li class="{{ Request::is('retur*') ? 'active' : '' }}">
                                    <a href="{{ route('retur.all') }}"><i class="fa-solid fa-truck" style="transform: scaleX(-1)"></i><span>Data Retur</span></a>
                                </li>
                                @endif
                                @if (auth()->user()->can('input.retur'))
                            </ul>
                        </li>
                        @endif
                        <!-- Stok -->
                        @if (auth()->user()->can('input.stock'))
                        <li>
                            <a href="#stock" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                                <i class="fa-solid fa-boxes-stacked"></i>
                                <span class="">Stok</span>
                                <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="stock" class="iq-submenu collapse" data-parent="#gudang">
                                @endif
                                @if (auth()->user()->can('stock'))
                                    <li class="{{ Request::is('stock*') ? 'active' : '' }}">
                                        <a href="{{ route('product.stock') }}"><i class="fa-solid fa-boxes-stacked"></i><span>Stok Tersedia</span></a>
                                    </li>
                                @endif
                                @if (auth()->user()->can('input.stock'))
                                <li class="{{ Request::is('inputstock') ? 'active' : '' }}">
                                    <a href="{{ route('input.stock') }}"><i class="fa-solid fa-arrow-right"></i><span>Input Stok</span></a>
                                </li>
                                <li class="{{ Request::is('stock*') ? 'active' : '' }}">
                                    <a href="{{ route('stock.all') }}"><i class="fa-solid fa-arrow-right"></i><span>Riwayat Stok Masuk</span></a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        <!-- Produk -->
                        @if (auth()->user()->can('input.product'))
                            <li class="{{ Request::is('products*') ? 'active' : '' }}">
                                <a href="{{ route('products.index') }}"><i class="fa-solid fa-boxes-stacked"></i><span>Daftar Produk</span></a>
                            </li>
                        @endif
                        <!-- Supplier -->
                        @if (auth()->user()->can('supplier'))
                            <li class="{{ Request::is('suppliers') ? 'active' : '' }}">
                                <a href="{{ route('suppliers.index') }}" class="svg-icon"><i class="fa-solid fa-users"></i><span class="">Suppliers</span></a>
                            </li>
                        @endif
                        <!-- Publisher -->
                        @if (auth()->user()->can('publisher'))
                            <li class="{{ Request::is('publisher') ? 'active' : '' }}">
                                <a href="{{ route('publisher.index') }}" class="svg-icon"><i class="fa-solid fa-users"></i><span class="">Penerbit</span></a>
                            </li>
                        @endif
                        @if (auth()->user()->can('supplier'))
                    </ul>
                </li>
                @endif
            <!-- Human Resource -->
                @if (auth()->user()->can('employee') || auth()->user()->can('salary'))
                <li>
                    <a href="#humanResource" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-users"></i><span>Kepegawaian</span>
                        <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="humanResource" class="iq-submenu collapse" data-parent="#sidebar-menu-toggle">
                        <!-- Kepegawaian -->
                            <li>
                                <a href="#employeeManagement" class="collapsed" data-bs-toggle="collapse" aria-expanded="false" data-parent="#humanResource">
                                    <i class="fa-solid fa-sitemap"></i><span class="ml-1">Data Pegawai</span>
                                    <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="10 15 15 20 20 15"></polyline>
                                        <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                    </svg>
                                </a>
                                <ul id="employeeManagement" class="iq-submenu collapse" >
                                    <li class="{{ Request::is('employees*') ? 'active' : '' }}">
                                        <a href="{{ route('employees.index') }}" class="svg-icon"><i class="fa-solid fa-users"></i><span class="ml-1">Pegawai</span></a>
                                    </li>
                                    <li class="{{ Request::is('position*') ? 'active' : '' }}">
                                        <a href="{{ route('position.index') }}" class="svg-icon"><i class="fa-solid fa-sitemap"></i><span class="ml-1">Jabatan</span></a>
                                    </li>
                                    <li class="{{ Request::is('department*') ? 'active' : '' }}">
                                        <a href="{{ route('department.index') }}" class="svg-icon"><i class="fa-solid fa-building"></i><span class="ml-1">Divisi</span></a>
                                    </li>
                                </ul>
                            </li>
                        <!-- Kehadiran Semua Pegawai -->
                        <li class="{{ Request::is(['attendance']) ? 'active' : '' }}">
                            <a href="{{ route('attendance.index', ['year' => date('Y')]) }}"><i class="fa-solid fa-calendar-days"></i><span>Absensi</span></a>
                        </li>
                        <!-- Salary -->
                            <li>
                                <a href="#advance-salary" class="collapsed" data-bs-toggle="collapse" aria-expanded="false" data-parent="#humanResource">
                                    <i class="fa-solid fa-cash-register"></i><span class="ml-1">Salary</span>
                                    <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="10 15 15 20 20 15"></polyline>
                                        <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                    </svg>
                                </a>
                                <ul id="advance-salary" class="iq-submenu collapse" >
                                    <li class="{{ Request::is(['advance-salary', 'advance-salary/*/edit']) ? 'active' : '' }}">
                                        <a href="{{ route('advance-salary.index') }}"><i class="fa-solid fa-arrow-right"></i><span>All Advance Salary</span></a>
                                    </li>
                                    <li class="{{ Request::is('advance-salary/create*') ? 'active' : '' }}">
                                        <a href="{{ route('advance-salary.create') }}"><i class="fa-solid fa-arrow-right"></i><span>Create Advance Salary</span></a>
                                    </li>
                                    <li class="{{ Request::is('pay-salary') ? 'active' : '' }}">
                                        <a href="{{ route('pay-salary.index') }}"><i class="fa-solid fa-arrow-right"></i><span>Pay Salary</span></a>
                                    </li>
                                    <li class="{{ Request::is('pay-salary/history*') ? 'active' : '' }}">
                                        <a href="{{ route('pay-salary.payHistory') }}"><i class="fa-solid fa-arrow-right"></i><span>History Pay Salary</span></a>
                                    </li>
                                </ul>
                            </li>
                    </ul>
                </li>
                @endif

            <!-- Finance -->
                @if (auth()->user()->can('input.collection'))
                <li>
                    <a href="#finance" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-cog"></i><span class="ml-1">Finance</span>
                        <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="finance" class="iq-submenu collapse" data-parent="#sidebar-menu-toggle">
                        @endif
                        @if (auth()->user()->can('input.collection'))
                        <!-- Collection -->
                            <li>
                                <a href="#collection" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                                    <i class="fa-solid fa-cart-shopping"></i><span class="">Collection</span>
                                    <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                    </svg>
                                </a>
                                <ul id="collection" class="iq-submenu collapse" data-parent="#finance">
                                    <li class="{{ Request::is('collection*') ? 'active' : '' }}">
                                        <a href="{{ route('input.collection') }}" class="svg-icon"><i class="fa-solid fa-cart-shopping"></i><span>Input Collection</span></a>
                                    </li>
                                    @endif
                                    @if (auth()->user()->can('collection'))
                                    <li class="{{ Request::is('collection*') ? 'active' : '' }}">
                                        <a href="{{ route('collection.all') }}" class="svg-icon"><i class="fa fa-dollar"></i><span>Data Collection</span></a>
                                    </li>
                                    @endif
                                    @if (auth()->user()->can('input.collection'))
                                </ul>
                            </li>
                            @endif
                        <!-- Bank -->
                            @if (auth()->user()->can('input.collection'))
                            <li>
                                <a href="#bank" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                                    <i class="fa-solid fa-key me-3"></i><span>Bank</span>
                                    <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                    </svg>
                                </a>
                                <ul id="bank" class="iq-submenu collapse" data-parent="#finance">
                                    <li class="{{ Request::is('rekening*') ? 'active' : '' }}">
                                        <a href="{{ route('rekening.index') }}" class="svg-icon"><i class="fa-solid fa-users me-3"></i><span class="ml-1">Rekening</span></a>
                                    </li>
                                    <li class="{{ Request::is('bank*') ? 'active' : '' }}">
                                        <a href="{{ route('bank.index') }}" class="svg-icon"><i class="fa-solid fa-users me-3"></i><span class="ml-1">Bank</span></a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                            @if (auth()->user()->can('input.collection'))
                    </ul>
                </li>
                @endif
                
            <!-- Publishing -->
                @if (auth()->user()->can('input.writer'))
                <li>
                    <a href="#publishing" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-cog"></i><span class="ml-1">Publishing</span>
                        <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="publishing" class="iq-submenu collapse" data-parent="#sidebar-menu-toggle">
                        @endif
                        @if (auth()->user()->can('input.writer'))
                        <!-- Writer -->
                            <li class="{{ Request::is('writer*') ? 'active' : '' }}">
                                {{-- <a href="{{ route('writer.create') }}" class="svg-icon"><i class="fa-solid fa-cart-shopping"></i><span>Input Penulis</span></a> --}}
                                <a href="{{ route('writer.index') }}" class="svg-icon"><i class="fa-solid fa-basket-shopping"></i><span>Penulis</span></a>
                            </li>
                            {{-- <li>
                                <a href="#writer" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                                    <i class="fa-solid fa-cart-shopping"></i><span class="">Penulis</span>
                                    <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                    </svg>
                                </a>
                                <ul id="writer" class="iq-submenu collapse" data-parent="#publishing">
                                    <li class="{{ Request::is('writer*') ? 'active' : '' }}">
                                        <a href="{{ route('writer.index') }}" class="svg-icon"><i class="fa-solid fa-basket-shopping"></i><span>Data Penulis</span></a>
                                    </li>
                                    @endif
                                    @if (auth()->user()->can('writer'))
                                    <li class="{{ Request::is('writer*') ? 'active' : '' }}">
                                        <a href="{{ route('writerjob.index') }}" class="svg-icon"><i class="fa-solid fa-basket-shopping"></i><span>Profesi Penulis</span></a>
                                    </li>
                                    <li class="{{ Request::is('writer*') ? 'active' : '' }}">
                                        <a href="{{ route('writercategory.index') }}" class="svg-icon"><i class="fa-solid fa-basket-shopping"></i><span>Kategori Penulis</span></a>
                                    </li>
                                    @endif
                                    @if (auth()->user()->can('input.writer'))
                                </ul>
                            </li> --}}
                            @endif
                        <!-- Produk -->
                            @if (auth()->user()->can('input.writer'))
                                <li class="{{ Request::is('products*') ? 'active' : '' }}">
                                    <a href="{{ route('products.index') }}"><i class="fa-solid fa-boxes-stacked"></i><span>Buku</span></a>
                                </li>
                            @endif
                        @if (auth()->user()->can('input.writer'))
                    </ul>
                </li>
                @endif
                
            <!-- Setting -->
                @if (auth()->user()->can('roles.menu'))
                <li>
                    <a href="#settings" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-cog"></i><span class="ml-1">Settings</span>
                        <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="settings" class="iq-submenu collapse" data-parent="#sidebar-menu-toggle">
                        @endif
                        <!-- Account Roles -->
                        @if (auth()->user()->can('roles.menu'))
                            <li>
                                <a href="#permission" class="collapsed" data-bs-toggle="collapse" aria-expanded="false">
                                    <i class="fa-solid fa-key me-3"></i><span>Role & Permission</span>
                                    <svg class="svg-icon arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                    </svg>
                                </a>
                                <ul id="permission" class="iq-submenu collapse">
                                    <li class="{{ Request::is(['permission', 'permission/create', 'permission/edit/*']) ? 'active' : '' }}">
                                        <a href="{{ route('permission.index') }}"><i class="fa-solid fa-arrow-right"></i><span>Permissions</span></a>
                                    </li>
                                    <li class="{{ Request::is(['role', 'role/create', 'role/edit/*']) ? 'active' : '' }}">
                                        <a href="{{ route('role.index') }}"><i class="fa-solid fa-arrow-right"></i><span>Roles</span></a>
                                    </li>
                                    <li class="{{ Request::is(['role/permission*']) ? 'active' : '' }}">
                                        <a href="{{ route('rolePermission.index') }}"><i class="fa-solid fa-arrow-right"></i><span>Role in Permissions</span></a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <!-- User -->
                        @if (auth()->user()->can('user.menu'))
                            <li class="{{ Request::is('users*') ? 'active' : '' }}">
                                <a href="{{ route('users.index') }}" class="svg-icon"><i class="fa-solid fa-users me-3"></i><span class="ml-1">Users</span></a>
                            </li>
                        @endif
                        <!-- Database -->
                        @if (auth()->user()->can('database.menu'))
                            <li class="{{ Request::is('database/backup*') ? 'active' : '' }}">
                                <a href="{{ route('backup.index') }}" class="svg-icon"><i class="fa-solid fa-database me-3"></i><span>Backup Database</span></a>
                            </li>
                        @endif
                        @if (auth()->user()->can('database.menu'))
                    </ul>
                </li>
                @endif
            </ul>
        </nav>
        <div class="p-3"></div>
    </div>
</div>
