<div class="main-menu menu-fixed menu-light menu-accordion no-print   menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            @can('List_Users')
                <li class="nav-item {{ isActiveRoute(['user.index', 'user.create', 'user.edit'], 'active') }}">
                    <a href="{{ route('user.index') }}">
                        <i class="fa-solid fa-circle-user"></i>
                        <span class="menu-title">User Management</span>
                    </a>
                </li>
            @endcan

            @if(auth()->user()->can('List_Students_Type') || auth()->user()->can('List_Students'))
                <li id="content" class="nav-item {{ isActiveRoute(['student-type.*','student.*'], 'open') }}">
                    <a href="#">
                        <i class="fa-solid fa-folder-tree"></i>
                        <span class="menu-title">Manage Students</span>
                    </a>
                    <ul class="menu-content">
                        @can('List_Students_Type')
                            <li class="nav-item {{ isActiveRoute(['student-type.index', 'student-type.create', 'student-type.edit'], 'active') }}">
                                <a href="{{ route('student-type.index') }}">
                                    <i class="fa-solid fa-tags"></i>
                                    <span class="menu-title">Student Type</span>
                                </a>
                            </li>
                        @endcan

                        @can('List_Students')
                            <li class="nav-item {{ isActiveRoute(['student.index', 'student.create', 'student.edit'], 'active') }}">
                                <a href="{{ route('student.index') }}">
                                    <i class="fa-regular fa-newspaper"></i>
                                    <span class="menu-title">Students</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif
                @can('List_Custom_Field')
                    <li class="nav-item {{ isActiveRoute(['custom-field.index', 'custom-field.create', 'custom-field.edit'], 'active') }}">
                        <a href="{{ route('custom-field.index') }}">
                            <i class="fa-solid fa-bars"></i>
                            <span class="menu-title">Custom Field</span>
                        </a>
                    </li>
                @endcan
                @can('List_Payments')
                    <li class="nav-item {{ isActiveRoute(['payment.index', 'payment.create', 'payment.edit'], 'active') }}">
                        <a href="{{ route('payment.index') }}">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            <span class="menu-title">Payments</span>
                        </a>
                    </li>
                @endcan

                @can('List_Courses_Status')
                    <li class="nav-item {{ isActiveRoute(['courses-status.index', 'courses-status.create', 'courses-status.edit'], 'active') }}">
                        <a href="{{ route('courses-status.index') }}">
                            <i class="fa-solid fa-arrow-right"></i>
                            <span class="menu-title">Courses Status</span>
                        </a>
                    </li>
                @endcan









            @if(auth()->user()->can('List_Role') || auth()->user()->can('Assign_Permission'))
                    <li id="content" class="nav-item {{ isActiveRoute(['roles.*','assign-permissions.*'], 'open') }}">
                        <a href="#">
                            <i class="fa-solid fa-folder-tree"></i>
                            <span class="menu-title">Manage Permission</span>
                        </a>
                        <ul class="menu-content">
                            @can('List_Role')
                                <li class="nav-item {{ isActiveRoute(['roles.index', 'roles.create', 'roles.edit'], 'active') }}">
                                    <a href="{{ route('roles.index') }}">
                                        <i class="fa-solid fa-tags"></i>
                                        <span class="menu-title">Roles</span>
                                    </a>
                                </li>
                            @endcan

                            @can('Assign_Permission')
                                <li class="nav-item {{ isActiveRoute(['assign-permissions'], 'active') }}">
                                    <a href="{{ route('assign-permissions') }}">
                                        <i class="fa-regular fa-newspaper"></i>
                                        <span class="menu-title">Permissions</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif


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
