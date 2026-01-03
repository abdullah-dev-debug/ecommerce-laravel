<header class="app-layout-header">
    <div class="header-left">
        <a href="javascript:void(0)" id="appSidebarToggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <rect width="24" height="24" fill="none" />
                <path fill="#0a0c0f" d="M3 18v-2h18v2zm0-5v-2h18v2zm0-5V6h18v2z" />
            </svg>
        </a>
        <h2 class="header-title" id="header-title">
            Ecommerce Dashboard
        </h2>
    </div>
    <div class="header-right">
        <div class="header-profile">
            <img src="{{ asset("assets/image/profile.jpg") }}" alt="Ecommerce Panel Profile">
            <ul>
                <li class="text-center username">
                    {{ session('admin.name') }}
                </li>
                <li class="role">
                    {{ session('admin.role_name') }}
                </li>
            </ul>
        </div>
    </div>
</header>