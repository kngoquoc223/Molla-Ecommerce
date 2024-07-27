@php
    $segment= request()->segment(2);
@endphp
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('show-dashboard')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{($segment=='dashboard')?'active':''}}">
        <a class="nav-link" href="{{route('show-dashboard')}}">
            <i class="fas fa-chart-bar"></i>
            <span>Thống Kê</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Quản lý
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    @foreach (config('apps.module.module') as $key => $val)        
    <li class="nav-item {{($segment==$val['id'])?'active':''}}">
        <a class="{{($segment==$val['id'])?'nav-link':'nav-link collapsed'}}" href="#" data-toggle="collapse" data-target="#collapse{{$val['id']}}">
            <i class="{{$val['icon']}}"></i>
            <span>{{$val['title']}}</span>
        </a>
        @if(@isset($val['subModule']))
        <div id="collapse{{$val['id']}}" class="{{($segment==$val['id'])?'collapse show':'collapse'}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách</h6>
                @foreach ($val['subModule'] as $module)
                <a class="collapse-item" href="{{url($module['route'])}}">{{$module['title']}}</a>
                @endforeach
            </div>
        </div>
        @endif
    </li>
    @endforeach

    <!-- Nav Item - Utilities Collapse Menu -->


    <!-- Heading -->
    <div class="sidebar-heading">
        Tiện ích
    </div>

    <!-- Nav Item - Pages Collapse Menu -->


    <!-- Nav Item - Charts -->


    <!-- Nav Item - Tables -->


     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>
    
                <!-- Sidebar Message -->
    
    <!-- End of Sidebar -->
</ul>