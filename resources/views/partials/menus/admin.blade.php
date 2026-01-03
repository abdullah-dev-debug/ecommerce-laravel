<li class="menu-item">
    <a href="#">
        <iconify-icon icon="mdi:view-dashboard-outline"></iconify-icon>
        <div class="menu-heading">Dashboard</div>
    </a>
</li>

<!-- Users & Customers -->
<li class="has-submenu">
    <a class="dropdown-btn-wrap" href="javascript:void(0)">
        <div class="dropdown-btn-col-1">
            <iconify-icon icon="mdi:account-group-outline"></iconify-icon>
            <span class="menu-heading">Users</span>
        </div>
        <iconify-icon icon="ic:sharp-keyboard-arrow-down" class="chervon-arrow-down"></iconify-icon>
    </a>
    <ul class="submenu">
        <li><a href="{{ route('admin.user.list') }}">All Customers</a></li>
        <li><a href="#">Address Book</a></li>
        <li><a href="#">Customer Reviews</a></li>
        <!-- Customer Groups future featured -->
        <!-- <li><a href="#">Customer Groups</a></li> --> 
    </ul>
</li>

<!-- Vendors -->
<li class="has-submenu">
    <a class="dropdown-btn-wrap" href="javascript:void(0)">
        <div class="dropdown-btn-col-1">
            <iconify-icon icon="mdi:storefront-outline"></iconify-icon>
            <span class="menu-heading">Vendors</span>
        </div>
        <iconify-icon icon="ic:sharp-keyboard-arrow-down" class="chervon-arrow-down"></iconify-icon>
    </a>
    <ul class="submenu">
        <li><a href="#">All Vendors</a></li>
        <li><a href="#">Pending Approvals</a></li>
        <li><a href="#">Vendor Packages</a></li>
        <li><a href="#">Commission Settings</a></li>
        <li><a href="#">Vendor Payouts</a></li>
        <li><a href="#">Vendor Verification</a></li>
    </ul>
</li>
<!-- Category Management -->
<li class="has-submenu">
    <a class="dropdown-btn-wrap" href="javascript:void(0)">
        <div class="dropdown-btn-col-1">
            <iconify-icon icon="mdi:shape-outline"></iconify-icon>
            <span class="menu-heading">Category Management</span>
        </div>
        <iconify-icon icon="ic:sharp-keyboard-arrow-down" class="chervon-arrow-down"></iconify-icon>
    </a>
    <ul class="submenu">
        <li>
            <a href="{{ route('admin.categories.list') }}">
                All Categories
            </a>
        </li>
        <li>
            <a href="{{ route('admin.subcategories.list') }}">
                Sub Categories
            </a>
        </li>
    </ul>
</li>

<!-- Catalog Management -->
<li class="has-submenu">
    <a class="dropdown-btn-wrap" href="javascript:void(0)">
        <div class="dropdown-btn-col-1">
            <iconify-icon icon="mdi:shopping-outline"></iconify-icon>
            <span class="menu-heading">Catalog</span>
        </div>
        <iconify-icon icon="ic:sharp-keyboard-arrow-down" class="chervon-arrow-down"></iconify-icon>
    </a>
    <ul class="submenu">
        <li><a href="{{ route('admin.products.list') }}">All Products</a></li>
        <li><a href="{{ route('admin.catalog.vendor.products') }}">Vendor Products</a></li>
        <li><a href="{{ route('admin.catalog.featured.products') }}">Featured Products</a></li>
        <li><a href="{{ route('admin.catalog.brand.list') }}">Brands</a></li>
        <li><a href="{{ route('admin.attributes.list') }}">Attributes</a></li>
        <li><a href="{{ route('admin.catalog.reviews.list') }}">Product Reviews</a></li>
        <li><a href="{{ route('admin.catalog.inventory') }}">Inventory</a></li>
    </ul>
</li>

<!-- Orders Management -->
<li class="has-submenu">
    <a class="dropdown-btn-wrap" href="javascript:void(0)">
        <div class="dropdown-btn-col-1">
            <iconify-icon icon="mdi:cart-outline"></iconify-icon>
            <span class="menu-heading">Orders</span>
        </div>
        <iconify-icon icon="ic:sharp-keyboard-arrow-down" class="chervon-arrow-down"></iconify-icon>
    </a>
    <ul class="submenu">
        <li><a href="{{ route('admin.orders.list') }}">All Orders</a></li>
        <li><a href="#">Pending Orders</a></li>
        <li><a href="#">Processing Orders</a></li>
        <li><a href="#">Completed Orders</a></li>
        <li><a href="#">Cancelled Orders</a></li>
        <li><a href="#">Returns & Refunds</a></li>
        <li><a href="#">Order Tracking</a></li>
    </ul>
</li>

<!-- Sales & Commission -->
<li class="has-submenu">
    <a class="dropdown-btn-wrap" href="javascript:void(0)">
        <div class="dropdown-btn-col-1">
            <iconify-icon icon="mdi:cash-multiple"></iconify-icon>
            <span class="menu-heading">Sales & Payouts</span>
        </div>
        <iconify-icon icon="ic:sharp-keyboard-arrow-down" class="chervon-arrow-down"></iconify-icon>
    </a>
    <ul class="submenu">
        <li><a href="#">Sales Report</a></li>
        <li><a href="#">Commission Report</a></li>
        <li><a href="#">Vendor Earnings</a></li>
        <li><a href="#">Payout Requests</a></li>
        <li><a href="#">Transaction History</a></li>
        <li><a href="#">Tax Collection</a></li>
    </ul>
</li>

<!-- Promotions -->
<li class="has-submenu">
    <a class="dropdown-btn-wrap" href="javascript:void(0)">
        <div class="dropdown-btn-col-1">
            <iconify-icon icon="mdi:tag-outline"></iconify-icon>
            <span class="menu-heading">Promotions</span>
        </div>
        <iconify-icon icon="ic:sharp-keyboard-arrow-down" class="chervon-arrow-down"></iconify-icon>
    </a>
    <ul class="submenu">
        <li><a href="#">Coupons</a></li>
        <li><a href="#">Discounts</a></li>
        <li><a href="#">Flash Sales</a></li>
        <li><a href="#">Deals of the Day</a></li>
        <li><a href="#">Bundles & Combos</a></li>
    </ul>
</li>

<!-- Shipping -->
<li class="has-submenu">
    <a class="dropdown-btn-wrap" href="javascript:void(0)">
        <div class="dropdown-btn-col-1">
            <iconify-icon icon="mdi:truck-delivery-outline"></iconify-icon>
            <span class="menu-heading">Shipping</span>
        </div>
        <iconify-icon icon="ic:sharp-keyboard-arrow-down" class="chervon-arrow-down"></iconify-icon>
    </a>
    <ul class="submenu">
        <li><a href="#">Shipping Methods</a></li>
        <li><a href="#">Shipping Zones</a></li>
        <li><a href="#">Delivery Boys</a></li>
        <li><a href="#">Tracking Settings</a></li>
        <li><a href="#">Shipping Labels</a></li>
    </ul>
</li>

<!-- Content Management -->
<li class="has-submenu">
    <a class="dropdown-btn-wrap" href="javascript:void(0)">
        <div class="dropdown-btn-col-1">
            <iconify-icon icon="mdi:newspaper-variant-outline"></iconify-icon>
            <span class="menu-heading">Content</span>
        </div>
        <iconify-icon icon="ic:sharp-keyboard-arrow-down" class="chervon-arrow-down"></iconify-icon>
    </a>
    <ul class="submenu">
        <li><a href="#">Pages</a></li>
        <li><a href="#">Blog</a></li>
        <li><a href="#">Banners & Sliders</a></li>
        <li><a href="#">FAQs</a></li>
        <li><a href="#">Newsletter</a></li>
        <li><a href="#">Email Templates</a></li>
    </ul>
</li>

<!-- Support -->
<li class="has-submenu">
    <a class="dropdown-btn-wrap" href="javascript:void(0)">
        <div class="dropdown-btn-col-1">
            <iconify-icon icon="mdi:headset"></iconify-icon>
            <span class="menu-heading">Support</span>
        </div>
        <iconify-icon icon="ic:sharp-keyboard-arrow-down" class="chervon-arrow-down"></iconify-icon>
    </a>
    <ul class="submenu">
        <li><a href="#">Tickets</a></li>
        <li><a href="#">Live Chat</a></li>
        <li><a href="#">Contact Messages</a></li>
        <li><a href="#">Knowledge Base</a></li>
    </ul>
</li>

<!-- Reports & Analytics -->
<li class="has-submenu">
    <a class="dropdown-btn-wrap" href="javascript:void(0)">
        <div class="dropdown-btn-col-1">
            <iconify-icon icon="mdi:chart-bar"></iconify-icon>
            <span class="menu-heading">Analytics</span>
        </div>
        <iconify-icon icon="ic:sharp-keyboard-arrow-down" class="chervon-arrow-down"></iconify-icon>
    </a>
    <ul class="submenu">
        <li><a href="#">Sales Analytics</a></li>
        <li><a href="#">Customer Analytics</a></li>
        <li><a href="#">Vendor Performance</a></li>
        <li><a href="#">Product Analytics</a></li>
        <li><a href="#">Traffic Analytics</a></li>
    </ul>
</li>

<!-- Settings -->
<li class="has-submenu">
    <a class="dropdown-btn-wrap" href="javascript:void(0)">
        <div class="dropdown-btn-col-1">
            <iconify-icon icon="mdi:cog-outline"></iconify-icon>
            <span class="menu-heading">Settings</span>
        </div>
        <iconify-icon icon="ic:sharp-keyboard-arrow-down" class="chervon-arrow-down"></iconify-icon>
    </a>
    <ul class="submenu">
        <li><a href="#">General Settings</a></li>
        <li><a href="#">Payment Methods</a></li>
        <li><a href="#">Tax Settings</a></li>
        <li><a href="#">Currency Settings</a></li>
        <li><a href="#">Notification Settings</a></li>
        <li><a href="#">API Settings</a></li>
        <li><a href="#">Backup & Restore</a></li>
    </ul>
</li>

<!-- Admin Management -->
<li class="has-submenu">
    <a class="dropdown-btn-wrap" href="javascript:void(0)">
        <div class="dropdown-btn-col-1">
            <iconify-icon icon="mdi:shield-account-outline"></iconify-icon>
            <span class="menu-heading">Admin</span>
        </div>
        <iconify-icon icon="ic:sharp-keyboard-arrow-down" class="chervon-arrow-down"></iconify-icon>
    </a>
    <ul class="submenu">
        <li><a href="#">Admins & Staff</a></li>
        <li><a href="#">Roles & Permissions</a></li>
        <li><a href="#">Activity Logs</a></li>
        <li><a href="#">System Logs</a></li>
    </ul>
</li>

<!-- Logout -->
<li class="menu-item">
    <a href="{{ route('admin.logout') }}">
        <iconify-icon icon="mdi:logout"></iconify-icon>
        <div class="menu-heading">Logout</div>
    </a>
</li>