(() => {
    "use strict";

    document.addEventListener("DOMContentLoaded", () => {

        const phoneInputs = document.querySelectorAll(".phone-input");

        if (!phoneInputs.length || typeof window.intlTelInput === "undefined") {
            return;
        }

        phoneInputs.forEach((input) => {

            if (input.dataset.itiInitialized === "true") return;

            window.intlTelInput(input, {
                initialCountry: "us",
                separateDialCode: true,
                utilsScript:
                    "https://cdn.jsdelivr.net/npm/intl-tel-input@18.5.3/build/js/utils.js"
            });

            input.dataset.itiInitialized = "true";
        });

    });

})();
