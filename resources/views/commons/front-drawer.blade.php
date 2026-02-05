<div class="mdk-drawer js-mdk-drawer"
     id="default-drawer">
    <div class="mdk-drawer__content">
        <div class="sidebar sidebar-white-pickled-bluewood sidebar-left"
             data-perfect-scrollbar>

            <!-- Sidebar Content -->


            <div class="sidebar-heading firstone">Student</div>
            <ul class="sidebar-menu">

                <li class="sidebar-menu-item {{ isActiveRoute(['home-student','view-lesson','pdf.show','view-course'], 'activeme') }} ">
                    <a class="sidebar-menu-button"
                       href="{{route('home-student')}}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">home</span>
                        <span class="sidebar-menu-text">Courses</span>
                    </a>
                </li>

{{--                <li class="sidebar-menu-item {{ isActiveRoute(['change-password'], 'activeme') }} ">--}}
{{--                    <a class="sidebar-menu-button"--}}
{{--                       href="{{route('change-password')}}">--}}
{{--                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">lock</span>--}}
{{--                        <span class="sidebar-menu-text">Change Password</span>--}}
{{--                    </a>--}}
{{--                </li>--}}

                <li class="sidebar-menu-item {{ isActiveRoute(['my-invoices'], 'activeme') }} ">
                    <a class="sidebar-menu-button"
                       href="{{route('my-invoices')}}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">folder</span>
                        <span class="sidebar-menu-text">Invoices</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{ isActiveRoute(['my-payments'], 'activeme') }} ">
                    <a class="sidebar-menu-button"
                       href="{{route('my-payments')}}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">folder</span>
                        <span class="sidebar-menu-text">Payments</span>
                    </a>
                </li>



                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-button"
                       href="{{route('logout')}}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">logout</span>
                        <span class="sidebar-menu-text">Logout</span>
                    </a>
                </li>

            </ul>


            <!-- // END Sidebar Content -->

        </div>
    </div>
</div>
