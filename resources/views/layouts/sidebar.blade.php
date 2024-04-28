<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PROCUREMENT</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ Request::is('home*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class=" fa fa-home"></i>
            <span>Home</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Data Master
    </div>
    <li class="nav-item {{ Request::is('master/bank*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('master.bank.index') }}">
            <i class="fa fa-money-check"></i>
            <span>Bank</span></a>
    </li>
    <li class="nav-item {{ Request::is('master/kategori*') ? 'active' : '' }}">
        <a class=" nav-link" href="{{ route('master.kategori.index') }}">
            <i class="fa fa-th-list"></i>
            <span>Kategori Barang</span></a>
    </li>
    <li class="nav-item {{ Request::is('master/barang*') ? 'active' : '' }}">
        <a class=" nav-link" href="{{ route('master.barang.index') }}">
            <i class="fa fa-boxes"></i>
            <span>Barang</span></a>
    </li>
    <li class="nav-item {{ Request::is('master/vendor*') ? 'active' : '' }}">
        <a class=" nav-link" href="{{ route('master.vendor.index') }}">
            <i class="fa fa-store"></i>
            <span>Vendor</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Transaksi
    </div>

    <li class="nav-item {{ Request::is('transaksi*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('transaksi.index') }}">
            <i class=" fa fa-shopping-cart"></i>
            <span>Order Transaksi</span></a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>