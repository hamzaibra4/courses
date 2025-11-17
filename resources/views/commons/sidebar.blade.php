<div class="main-menu menu-fixed menu-light menu-accordion no-print   menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">


            @can('List_Role')
                <li class="nav-item {{ isActiveRoute(['roles.index', 'roles.create', 'roles.edit'], 'active') }}">
                    <a href="{{ route('roles.index') }}">
                        <i class="fas fa-user-shield"></i>
                        <span class="menu-title" data-i18n="nav.dash.main">Roles</span>
                    </a>
                </li>
            @endcan

            @can('Assign_Permission')
                <li class="nav-item {{ isActiveRoute(['assign-permissions'], 'active') }}">
                    <a href="{{ route('assign-permissions') }}">
                        <i class="fas fa-user-tag"></i>
                        <span class="menu-title" data-i18n="nav.dash.main">Assign Permissions</span>
                    </a>
                </li>
            @endcan



            @foreach($configurations as $config)
                @can("List_".$config->model_name)
                    <li class=" nav-item {{ isActiveRoute([$config->route, $config->route.'.create',  $config->route.'.edit'], 'active') }}"><a href="{{route($config->route)}}"><i class="{{$config->icon_class}}"></i><span class="menu-title" data-i18n="nav.dash.main">{{$config->screen_name}}</span></a>
                    </li>
                @endcan
            @endforeach


            <li class=" nav-item"><a href="{{route('logout')}}"><i class=" la la-sign-out"></i><span class="menu-title" data-i18n="nav.dash.main">logout</span></a>
            </li>

        </ul>
    </div>
</div><i class=""></i>
