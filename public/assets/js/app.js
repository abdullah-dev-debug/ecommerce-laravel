(() => {

    "use strict";

    let ticking = false;

    document.addEventListener("DOMContentLoaded", init);
    document.addEventListener("scroll", () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                stickyHeader();
                ticking = false;
            })
            ticking = true;
        }
    });


    window.addEventListener("resize", resizeInital);

    function resizeInital() {
        stickyHeader();
        updateHeroSecBtn();
    }

    function init() {
        toggleSidebar();
        toggleAnnouncementBar();
        announcementTimer();
        toggleCategoryMenu();
        appSliders();
        updateHeroSecBtn();
        tooltip();
        layout1();
        sweetAlert();
        multiSelect();
        updateHeader();
    }

    function isMobile() {
        return window.innerWidth <= 999;
    }

    function isDesktop() {
        return window.innerWidth >= 1024;
    }

    function toggleAnnouncementBar() {
        const announcementBarEL = document.querySelector('.announcement-bar');
        if (!announcementBarEL) return;
        const closeBtn = document.querySelector(".announcement-bar-close-btn")
        if (closeBtn) {
            closeBtn.addEventListener("click", () => {
                announcementBarEL.classList.toggle("hidden-announcement-bar");
            });
        }
    }

    const formatter = new Intl.DateTimeFormat("en-US", {
        timeZone: "America/New_York",
        day: "2-digit",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: false
    });

    function announcementTimer() {
        const parts = formatter.formatToParts(new Date());
        const get = type => parts.find(p => p.type === type).value;

        const dayEl = document.querySelector('.announcement-day');
        const hourEl = document.querySelector('.announcement-hour');
        const minEl = document.querySelector('.announcement-min');
        const secEl = document.querySelector('.announcement-sec');

        if (dayEl) dayEl.innerHTML = get("day");
        if (hourEl) hourEl.innerHTML = get("hour");
        if (minEl) minEl.innerHTML = get("minute");
        if (secEl) secEl.innerHTML = get("second");
    }


    setInterval(announcementTimer, 1000);



    function toggleCategoryMenu() {
        const categoryMenuEL = document.querySelector('.category-menu-dropdown');
        const categoryDropdownBtn = document.querySelector('.category-dropdown-btn');
        if (!categoryMenuEL) return;
        if (categoryDropdownBtn) {
            categoryDropdownBtn.addEventListener("click", () => {
                categoryMenuEL.classList.toggle('active');
            })
        }
    }

    function stickyHeader() {
        const header = document.querySelector("#app-main-header");
        const navbar = document.querySelector('.app-navigation-container');
        if (!header || !navbar) return;

        navbar.classList.toggle("sticky-app-navbar", window.scrollY > 200 && isDesktop());
        header.classList.toggle("sticky-app-header", window.scrollY > 100 && isMobile());
    }

    function toggleSidebar() {
        const overlayEL = document.querySelector(".sidebar-overlay");
        const closeBtnEL = document.querySelector(".sidebar-close-btn");
        const sidebarEL = document.querySelector(".sidebar-container");
        const menuBtn = document.querySelector(".humbarger-menu");
        const menusEL = document.querySelectorAll(".sidebar-menu-list li a");
        if (!menuBtn || !overlayEL || !closeBtnEL || !sidebarEL) return;
        menuBtn.addEventListener("click", toggleMobileMenu);
        overlayEL.addEventListener("click", toggleMobileMenu);
        closeBtnEL.addEventListener("click", toggleMobileMenu);
        menusEL.forEach((menu) => {
            menu.addEventListener("click", toggleMobileMenu);
        })
        function toggleMobileMenu() {
            overlayEL.classList.toggle('active');
            closeBtnEL.classList.toggle('active');
            sidebarEL.classList.toggle('active')
        }
    }

    function updateHeroSecBtn() {
        const heroContentBtn = document.querySelectorAll('.hero-sec-cta-btn');
        if (!heroContentBtn) return;
        heroContentBtn.forEach((btn) => {
            btn.classList.remove('bs-btn-primary', 'bs-btn-white');
            btn.classList.add(
                isMobile() ? 'bs-btn-primary' : 'bs-btn-white'
            );
        })
    }

    function appSliders() {
        swiperSlider('.hero-sec-swiper');
    }


    function swiperSlider(className = '.mySwiper', paginationClass = ".swiper-pagination") {
        new Swiper(className, {
            pagination: {
                el: paginationClass,
                clickable: true,

            },
        });
    }

    function tooltip() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

    }


    function layout1() {
        const appSidebarBtn = document.getElementById("appSidebarToggle");
        const layout1Sidebar = document.querySelector(".app-sidebar");
        const appSidebarCloseBtn = document.getElementById("appSidebarCloseToggle");

        // Sidebar toggle open/close
        if (appSidebarBtn && layout1Sidebar) {
            appSidebarBtn.addEventListener("click", function () {
                const className =
                    window.innerWidth < 999 ? "app-sidebar-open" : "app-sidebar-close";
                layout1Sidebar.classList.toggle(className);

                const dashboardHeader = document.querySelector(".app-layout-header");
                const mainContent = document.querySelector(".app-layout-main-content");

                if (layout1Sidebar.classList.contains("app-sidebar-close")) {
                    dashboardHeader?.classList.add("app-header-spc-remove");
                    mainContent?.classList.add("app-layout-main-content-spc-remove");
                } else {
                    dashboardHeader?.classList.remove("app-header-spc-remove");
                    mainContent?.classList.remove("app-layout-main-content-spc-remove");
                }
            });
        }

        // Sidebar close button
        if (appSidebarCloseBtn && layout1Sidebar) {
            appSidebarCloseBtn.addEventListener("click", () => {
                layout1Sidebar.classList.remove("app-sidebar-open");
            });
        }

        // Active page highlight
        if (layout1Sidebar) {
            const currentPath = window.location.pathname.replace(/\/$/, '');
            layout1Sidebar
                .querySelectorAll(".sidebar-menu-list li a")
                .forEach((linkEl) => {

                    const href = linkEl.getAttribute("href");
                    if (!href || href === "javascript:void(0)") return;

                    const linkPath = new URL(href, window.location.origin)
                        .pathname
                        .replace(/\/$/, '');

                    linkEl.classList.remove("sidebar-active-page-menu");

                    if (currentPath === linkPath) {
                        linkEl.classList.add("sidebar-active-page-menu");

                        // Also activate parent submenu
                        const parentLi = linkEl.closest(".has-submenu");
                        if (parentLi) {
                            parentLi.classList.add("active");
                        }
                    }
                });
        }


        document.querySelectorAll(".has-submenu > a").forEach((item) => {
            item.addEventListener("click", function (e) {
                e.preventDefault();
                this.parentElement.classList.toggle("open");
            });
        });
    }

    function multiSelect() {
        $(document).ready(function () {
            $('.multi-select').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        });
    }

    function sweetAlert() {
        document.querySelectorAll(".delete-confirm-btn").forEach(function (button) {
            button.addEventListener("click", function (e) {
                e.preventDefault();

                const title = this.dataset.title ?? "Are you sure?";
                const text = this.dataset.text ?? "You won't be able to revert this!";

                Swal.fire({
                    title: title,
                    text: text,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest("form").submit();
                    }
                });
            });
        });
    }


    function updateHeader() {
        const header = document.querySelector("#header-title");
        if (header) header.textContent = header.dataset.title;
    }

})();