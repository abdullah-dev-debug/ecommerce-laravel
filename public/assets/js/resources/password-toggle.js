(() => {
    "use strict";

    document.addEventListener("DOMContentLoaded", inital);

    function inital() {
        passwordVisibility()
    }
    
    function passwordVisibility() {
        const btnShowPassword = document.querySelectorAll(".password-eye-btn");

        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        btnShowPassword.forEach((btn) => {
            // Add Bootstrap data attributes
            btn.setAttribute('data-bs-toggle', 'tooltip');
            btn.setAttribute('data-bs-placement', 'top');
            btn.setAttribute('data-bs-title', 'Show password');

            // Initialize tooltip for this button
            new bootstrap.Tooltip(btn);

            btn.addEventListener("click", () => {
                const inputWrap = btn.closest('.password-input-wrap');
                const input = inputWrap.querySelector('.password-input');

                if (input.type === "password") {
                    input.type = "text";
                    btn.classList.remove("fa-eye-slash");
                    btn.classList.add("fa-eye");

                    // Update tooltip using Bootstrap 5 method
                    var tooltip = bootstrap.Tooltip.getInstance(btn);
                    if (tooltip) {
                        tooltip.setContent({ '.tooltip-inner': 'Hide password' });
                    }
                } else {
                    input.type = "password";
                    btn.classList.remove("fa-eye");
                    btn.classList.add("fa-eye-slash");

                    // Update tooltip
                    var tooltip = bootstrap.Tooltip.getInstance(btn);
                    if (tooltip) {
                        tooltip.setContent({ '.tooltip-inner': 'Show password' });
                    }
                }

                input.focus();
            });
        });
    }

})();