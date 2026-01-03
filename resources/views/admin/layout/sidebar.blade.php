<div class="app-sidebar">
    <div class="sidebar-item-container">
        <div class="sidebar-header-wrap">
            <div class="sidebar-logo">
                <a href="{{ url('/ecommerce/admin/dashboard') }}">
                    <img src="{{ asset("assets/image/ShopSphere.png") }}" alt="Ecommerce Panel">
                </a>
            </div>
            <a href="javascript:void(0)" id="appSidebarCloseToggle" class="close-btn">
                <iconify-icon icon="mdi:close"></iconify-icon>
            </a>
        </div>

        <ul class="sidebar-menu-list">

            @include('partials.menus.admin')
        </ul>

    </div>
</div>