<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('home') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="https://www.pnb.ac.id/img/logo-pnb.3aae610b.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <div class="gap-2 mt-3 d-flex align-items-center">
                    <img src="https://www.pnb.ac.id/img/logo-pnb.3aae610b.png" alt="Logo" height="32">
                    <div class="text-white flex-grow-2">
                        <h6 class="p-0 m-0 text-white opacity-75 fw-bolder">{{ config('app.name') }}</h6>
                        <h6 class="p-0 m-0 text-white opacity-50">Politeknik Negeri Bali</h6>
                    </div>
                </div>
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('home') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="https://www.pnb.ac.id/img/logo-pnb.3aae610b.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <div class="gap-2 mt-3 d-flex align-items-center">
                    <img src="https://www.pnb.ac.id/img/logo-pnb.3aae610b.png" alt="Logo" height="32">
                    <div class="text-white flex-grow-2">
                        <h6 class="p-0 m-0 text-white opacity-75 fw-bolder">{{ config('app.name') }}</h6>
                        <h6 class="p-0 m-0 text-white opacity-50">Politeknik Negeri Bali</h6>
                    </div>
                </div>
            </span>
        </a>
        <button type="button" class="p-0 btn btn-sm fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <x-menu-title title="Menu" />
                @if (auth()->user()->role->name == "admin")
                <x-navlink icon="ri-dashboard-line" title="Dashboard" href="{{ route('admin.dashboard') }}" active="{{ request()->routeIs('admin.dashboard') }}" />
                <x-navlink icon="ri-user-line" title="Manage User" href="{{ route('admin.user.index') }}" active="{{ request()->routeIs('admin.user.index') }}" />
                <x-navlink icon="ri-global-line" title="Manage Question" href="{{ route('admin.bank.index') }}" active="{{ request()->routeIs('admin.bank.index') }}" />
                <x-navlink icon="ri-calendar-line" title="Manage Session" href="{{ route('admin.token.index') }}" active="{{ request()->routeIs('admin.token.index') }}" />
                @elseif (auth()->user()->role->name == "super")
                <x-navlink icon="ri-dashboard-line" title="Dashboard" href="{{ route('super.dashboard') }}" active="{{ request()->routeIs('super.dashboard') }}" />
                <x-navlink icon="ri-user-line" title="Manage User" href="{{ route('super.admin.index') }}" active="{{ request()->routeIs('super.admin.index') }}" />
                @elseif (auth()->user()->role->name == "user")
                <x-navlink icon="ri-dashboard-line" title="Dashboard" href="{{ route('user.dashboard') }}" active="{{ request()->routeIs('user.dashboard') }}" />
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>