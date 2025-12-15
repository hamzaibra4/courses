<div class="mdk-drawer js-mdk-drawer"
     id="default-drawer">
    <div class="mdk-drawer__content">
        <div class="sidebar sidebar-white-pickled-bluewood sidebar-left"
             data-perfect-scrollbar>

            <!-- Sidebar Content -->


            <div class="sidebar-heading mt-3 ">Student</div>
            <ul class="sidebar-menu">

                <li class="sidebar-menu-item active">
                    <a class="sidebar-menu-button"
                       href="{{route('home-student')}}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">home</span>
                        <span class="sidebar-menu-text">Home</span>
                    </a>
                </li>

                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-button"
                       data-toggle="collapse"
                       href="#account_menu">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">account_box</span>
                        Account
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu collapse sm-indent"
                        id="account_menu">
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button"
                               href="{{route('change-password')}}">
                                <span class="sidebar-menu-text">Change Password</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button"
                               href="{{route('my-account')}}">
                                <span class="sidebar-menu-text">Edit Account</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>


            <!-- // END Sidebar Content -->

        </div>
    </div>
</div>
