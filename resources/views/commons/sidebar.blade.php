<div class="main-menu menu-fixed menu-light menu-accordion no-print   menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @can('List_Company')
                <li class="nav-item {{ isActiveRoute(['company.index', 'company.edit'], 'active') }}">
                    <a href="{{ route('company.index') }}">
                        <i class="fa-solid fa-building"></i>
                        <span class="menu-title">Company</span>
                    </a>
                </li>
            @endcan
            @can('List_Users')
                <li class="nav-item {{ isActiveRoute(['user.index', 'user.create', 'user.edit'], 'active') }}">
                    <a href="{{ route('user.index') }}">
                        <i class="fa-solid fa-circle-user"></i>
                        <span class="menu-title">User Management</span>
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


                @can('List_Custom_Field')
                    <li class="nav-item {{ isActiveRoute(['custom-field.index', 'custom-field.create', 'custom-field.edit'], 'active') }}">
                        <a href="{{ route('custom-field.index') }}">
                            <i class="fa-solid fa-bars"></i>
                            <span class="menu-title">Custom Field</span>
                        </a>
                    </li>
                @endcan

                @can('List_enRolled_Course')
                    <li class="nav-item {{ isActiveRoute(['enrolled-course.index', 'enrolled-course.create', 'enrolled-course.edit'], 'active') }}">
                        <a href="{{ route('enrolled-course.index') }}">
                            <i class="fa-solid fa-sign-in"></i>
                            <span class="menu-title">Student Enrollments</span>
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



                @can('List_Course')
                    <li class="nav-item {{ isActiveRoute(['course.index', 'course.create', 'course.edit'], 'active') }}">
                        <a href="{{ route('course.index') }}">
                            <i class="fa-solid fa-book-open"></i>
                            <span class="menu-title">Course</span>
                        </a>
                    </li>
                @endcan

                @can('List_Chapter')
                    <li class="nav-item {{ isActiveRoute(['chapter.index', 'chapter.create', 'chapter.edit'], 'active') }}">
                        <a href="{{ route('chapter.index') }}">
                            <i class="fa-solid fa-book"></i>
                            <span class="menu-title">Chapter</span>
                        </a>
                    </li>
                @endcan
                @can('List_Section')
                    <li class="nav-item {{ isActiveRoute(['section.index', 'section.create', 'section.edit'], 'active') }}">
                        <a href="{{ route('section.index') }}">
                            <i class="fa-solid fa-atlas"></i>
                            <span class="menu-title">Section</span>
                        </a>
                    </li>
                @endcan

                @can('List_Material')
                    <li class="nav-item {{ isActiveRoute(['material.index', 'material.create', 'material.edit'], 'active') }}">
                        <a href="{{ route('material.index') }}">
                            <i class="fa-solid fa-list"></i>
                            <span class="menu-title">Material</span>
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

                @can('List_Students_Type')
                    <li class="nav-item {{ isActiveRoute(['student-type.index', 'student-type.create', 'student-type.edit'], 'active') }}">
                        <a href="{{ route('student-type.index') }}">
                            <i class="fa-solid fa-tags"></i>
                            <span class="menu-title">Student Type</span>
                        </a>
                    </li>
                @endcan

            <li class=" nav-item"><a href="{{route('logout')}}"><i class=" la la-sign-out"></i><span class="menu-title" data-i18n="nav.dash.main">logout</span></a>
            </li>

        </ul>
    </div>
</div><i class=""></i>
