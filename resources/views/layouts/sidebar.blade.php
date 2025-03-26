<div class="iq-sidebar-logo d-flex justify-content-between">
    <a href="index.html" class="header-logo">
        <img src="{{asset('assets/images/logo.png')}}" class="img-fluid rounded-normal" alt="">
        <div class="logo-title">
            <span class="text-danger text-uppercase">Monitoring</span>
        </div>
    </a>
    <div class="iq-menu-bt-sidebar">
        <div class="iq-menu-bt align-self-center">
            <div class="wrapper-menu">
                <div class="main-circle"><i class="ri-arrow-left-s-line"></i></div>
                <div class="hover-circle"><i class="ri-arrow-right-s-line"></i></div>
            </div>
        </div>
    </div>
</div>
<div id="sidebar-scrollbar">
    <nav class="iq-sidebar-menu">
        <ul id="iq-sidebar-toggle" class="iq-menu">
        <li class="{{ Request::routeIs('dashboard') ? 'active active-menu' : '' }}">
    <a href="{{ route('dashboard') }}" class="iq-waves-effect">
        <i class="las la-house-damage"></i><span>Dashboard</span>
    </a>
</li>

<li class="{{ Request::routeIs('devices') ? 'active active-menu' : '' }}">
    <a href="{{ route('devices') }}" class="iq-waves-effect">
        <i class="las la-laptop iq-arrow-left"></i><span>Perangkat</span>
    </a>
</li>

<li class="{{ Request::routeIs('systems') ? 'active active-menu' : '' }}">
    <a href="{{ route('systems') }}" class="iq-waves-effect">
        <i class="las la-cloud-download-alt"></i><span>Sistem Mikrotik</span>
    </a>
</li>

<li class="{{ Request::routeIs('logs') ? 'active active-menu' : '' }}">
    <a href="{{ route('logs') }}" class="iq-waves-effect">
        <i class="las la-archive"></i><span>Log Aktivitas</span>
    </a>
</li>


        </ul>
    </nav>
</div>