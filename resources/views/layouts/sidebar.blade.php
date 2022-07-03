<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{route('home')}}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img style="height: 50px;" src="/orange-book.png" alt="">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">TNPSC Mains</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item active">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="fa-solid fa-chart-pie rounded menu-icon"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            @if (Auth::user()->user_type == 1)
                <span class="menu-header-text">Course Management</span>
            @endif
            @if (Auth::user()->user_type == 2)
                <span class="menu-header-text">Test Management</span>
            @endif
        </li>
        @if (@Auth::user()->user_type == 1)
            <li class="menu-item">

                <a href="{{ route('evaluator') }}" class="menu-link">
                    <i class="fa-solid fa-user-graduate rounded menu-icon"></i>

                    <div data-i18n="Analytics">Evaluator</div>
                </a>

            </li>

            <li class="menu-item">

                <a href="{{ route('exam') }}" class="menu-link">
                    <i class="fa-solid fa-book rounded menu-icon"></i>

                    <div data-i18n="Analytics">Exam</div>
                </a>

            </li>
            <li class="menu-item ">
                <a href="{{ route('course') }}" class="menu-link">
                    <i class="fa-solid fa-book rounded menu-icon"></i>
                    <div data-i18n="Analytics">Course</div>
                </a>
            </li>
        @endif






        <!-- Layouts -->
        <li class="menu-item open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-swatchbook rounded menu-icon"></i>

                <div data-i18n="Layouts">Test Management</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item ">
                    <a href="{{ route('test') }}" class="menu-link">
                        <i class="fa-solid fa-swatchbook rounded menu-icon"></i>
                        <div data-i18n="Analytics">Submitted Tests</div>
                    </a>
                </li>
                <li class="menu-item ">
                    <a href="{{ route('evaluation') }}" class="menu-link">
                        <i class="fa-solid fa-swatchbook rounded menu-icon"></i>
                        <div data-i18n="Analytics">Upload Evaluated Copy</div>
                    </a>
                </li>

            </ul>
        </li>
        @if (Auth::user()->user_type == 1)
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="fa-solid fa-user rounded menu-icon"></i>
                    <div data-i18n="Layouts">User Management</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{route('orders')}}" class="menu-link">
                            <i class="fa-solid fa-indian-rupee-sign rounded menu-icon"></i>
                            <div data-i18n="Without menu">Manage Orders</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('users')}}" class="menu-link">
                            <i class="fa-solid fa-user rounded menu-icon"></i>
                            <div data-i18n="Without navbar">Manage Users</div>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="menu-item">

                <a href="{{ route('enquiry') }}" class="menu-link">
                    <i class="fa-solid fa-circle-question rounded menu-icon"></i>

                    <div data-i18n="Analytics">Enquiries</div>
                </a>

            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Settings</span>
            </li>
            <li class="menu-item">

                <a href="{{ route('settings') }}" class="menu-link">
                    <i class="fa-solid fa-gear rounded menu-icon"></i>
                    <div data-i18n="Analytics">Settings</div>
                </a>

            </li>
        @endif



    </ul>
</aside>
<!-- / Menu -->
