@include('customer.layout.announcementbar')

<header id="app-main-header">
    <div class="main-container">
        <div class="header-items-wrap">
            <a href="javascript:void(0)" class="humbarger-menu">
                <iconify-icon icon="solar:hamburger-menu-linear" width="26"></iconify-icon>

            </a>
            <a href="/">
                <img src="{{ asset('assets/image/ShopSphere.png') }}" class="app-logo" alt="ShopSphere">
            </a>
            <div class="header-search-wrap">
                <select name="tags" id="product-tags" class="form-select">
                    <option value="" selected>
                        All Tags
                    </option>
                    <option value="airdrop">Air Drop</option>
                </select>
                <input type="text" placeholder="Search Our Product/Store" class="form-control">
                <button type="button" class="bs-btn bs-btn-primary header-search-btn">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </div>
            <div class="header-features-wrap">
                <a href="javascript:void(0)" class="search-feature-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <rect width="24" height="24" fill="none" />
                        <path fill="#000"
                            d="m19.485 20.154l-6.262-6.262q-.75.639-1.725.989t-1.96.35q-2.402 0-4.066-1.663T3.808 9.503T5.47 5.436t4.064-1.667t4.068 1.664T15.268 9.5q0 1.042-.369 2.017t-.97 1.668l6.262 6.261zM9.539 14.23q1.99 0 3.36-1.37t1.37-3.361t-1.37-3.36t-3.36-1.37t-3.361 1.37t-1.37 3.36t1.37 3.36t3.36 1.37" />
                    </svg>
                </a>
                <a href="/login" class="account-feature-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <rect width="24" height="24" fill="none" />
                        <path fill="#000"
                            d="M17.438 21.937H6.562a2.5 2.5 0 0 1-2.5-2.5v-.827c0-3.969 3.561-7.2 7.938-7.2s7.938 3.229 7.938 7.2v.827a2.5 2.5 0 0 1-2.5 2.5M12 12.412c-3.826 0-6.938 2.78-6.938 6.2v.827a1.5 1.5 0 0 0 1.5 1.5h10.876a1.5 1.5 0 0 0 1.5-1.5v-.829c0-3.418-3.112-6.198-6.938-6.198m0-2.501a3.924 3.924 0 1 1 3.923-3.924A3.927 3.927 0 0 1 12 9.911m0-6.847a2.924 2.924 0 1 0 2.923 2.923A2.926 2.926 0 0 0 12 3.064" />
                    </svg>
                </a>
                <a href="/wishlist" class="wishlist-feature-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <rect width="24" height="24" fill="none" />
                        <path fill="#000"
                            d="M4.24 12.25a4.2 4.2 0 0 1-1.24-3A4.25 4.25 0 0 1 7.25 5c1.58 0 2.96.86 3.69 2.14h1.12A4.24 4.24 0 0 1 15.75 5A4.25 4.25 0 0 1 20 9.25c0 1.17-.5 2.25-1.24 3L11.5 19.5zm15.22.71C20.41 12 21 10.7 21 9.25A5.25 5.25 0 0 0 15.75 4c-1.75 0-3.3.85-4.25 2.17A5.22 5.22 0 0 0 7.25 4A5.25 5.25 0 0 0 2 9.25c0 1.45.59 2.75 1.54 3.71l7.96 7.96z" />
                    </svg>
                    <span class="items-counter">0</span>
                </a>
                <a href="/cart" class="cart-feature-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <rect width="24" height="24" fill="none" />
                        <path fill="#000"
                            d="M9 20c0 1.1-.9 2-2 2s-1.99-.9-1.99-2S5.9 18 7 18s2 .9 2 2m8-2c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2s2-.9 2-2s-.9-2-2-2m.396-5a2 2 0 0 0 1.952-1.566L21 5H7V4a2 2 0 0 0-2-2H3v2h2v11a2 2 0 0 0 2 2h12a2 2 0 0 0-2-2H7v-2z" />
                    </svg>
                    <span class="items-counter">0</span>
                </a>
            </div>
        </div>
    </div>

    <nav class="app-navigation-container">
        <div class="main-container">
            <div class="navigation-items-wrap">
                <div class="app-menus-wrap">
                    @include('partials.menus.customer')
                </div>
                <a href="javascript:void(0)" class="item-wrap nav-list-deal-label">
                    <svg class="icon icon-accordion" aria-hidden="true" focusable="false"
                        xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M14.6792 0.161747C14.8796 0.280525 14.9715 0.522024 14.9006 0.743992L12.5162 8.21151L16.6937 9.21166C16.8685 9.2535 17.0074 9.38595 17.0575 9.55856C17.1076 9.73117 17.0612 9.91739 16.936 10.0463L7.56282 19.6949C7.39667 19.8659 7.13287 19.8958 6.93265 19.7663C6.73242 19.6368 6.65151 19.384 6.73935 19.1623L9.70397 11.6806L5.23445 10.6106C5.06054 10.5689 4.9221 10.4376 4.87139 10.2661C4.82068 10.0946 4.86541 9.9091 4.9887 9.77957L14.0621 0.247179C14.2228 0.0784039 14.4787 0.042969 14.6792 0.161747ZM6.3116 9.84018L10.4977 10.8424C10.6387 10.8761 10.7581 10.9694 10.8249 11.0981C10.8918 11.2267 10.8995 11.378 10.8461 11.5128L8.59272 17.1996L15.6066 9.97963L11.7597 9.05865C11.6245 9.02628 11.5089 8.93906 11.4406 8.81795C11.3723 8.69683 11.3575 8.55276 11.3998 8.42031L13.286 2.51296L6.3116 9.84018Z">
                        </path>
                    </svg>
                    UP TO 60% off All Items
                </a>
            </div>

        </div>

    </nav>

    @include('customer.layout.sidebar')
</header>