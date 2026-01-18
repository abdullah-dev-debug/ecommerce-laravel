(() => {
    "use strict";

    document.addEventListener("DOMContentLoaded", inital);

    function inital() {
        dataTable();
        handleResponsiveTable();
        window.addEventListener("resize", handleResponsiveTable);
    }


    /* ===============================
        DATATABLE INIT
    =============================== */

    function dataTable() {
        if (typeof $ === "undefined" || typeof $.fn.DataTable !== "function") {
            console.error("DataTables library not loaded!");
            return;
        }

        $(".load_dataTable_fn").each(function () {
            if (!$.fn.DataTable.isDataTable(this)) {
                $(this).DataTable({
                    responsive: false, // IMPORTANT
                    scrollX: false
                });
            }
        });
    }

    /* ===============================
        RESPONSIVE HANDLER
    =============================== */
    function handleResponsiveTable() {
        const isMobile = window.innerWidth <= 999;

        document.querySelectorAll(".responsive-table").forEach(wrapper => {
            if (isMobile) {
                wrapper.classList.add("table-responsive");
            } else {
                wrapper.classList.remove("table-responsive");
            }
        });
    }
})();