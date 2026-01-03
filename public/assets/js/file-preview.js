(() => {
    "use strict";

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".fm-group").forEach(initPreview);
    });

    function initPreview(group) {
        const input = group.querySelector(".file-input");
        const wrapper = group.querySelector(".fp-wrapper");
        const previewWrap = wrapper?.querySelector(".fp-preview-wrap");
        const placeholderImg = wrapper?.querySelector(".fp-placeholder img");

        if (!input || !wrapper || !previewWrap || !placeholderImg) return;

        const WIDTH = placeholderImg.getAttribute("width");
        const HEIGHT = placeholderImg.getAttribute("height");

        wrapper.addEventListener("click", () => input.click());
        input.addEventListener("change", render);

        function render() {
            previewWrap.innerHTML = "";

            if (input.files.length === 0) {
                wrapper.querySelector(".fp-placeholder").classList.remove("fp-hidden");
                return;
            }

            wrapper.querySelector(".fp-placeholder").classList.add("fp-hidden");

            Array.from(input.files).forEach((file, index) => {
                if (!file.type.startsWith("image/")) return;

                const col = document.createElement("div");
                col.className = input.multiple
                    ? "col-12 col-sm-6 col-md-4 fp-item"
                    : "col-auto fp-item";

                col.style.width = WIDTH + "px";
                col.style.height = HEIGHT + "px";

                const img = document.createElement("img");
                img.src = URL.createObjectURL(file);
                img.style.width = "100%";
                img.style.height = "100%";
                img.style.objectFit = "cover";
                img.className = "img-thumbnail";

                img.onload = () => URL.revokeObjectURL(img.src);

                col.appendChild(img);

                // Remove button only for multiple files
                if (input.multiple) {
                    const btn = document.createElement("button");
                    btn.type = "button";
                    btn.className = "fp-remove";
                    btn.innerHTML = `<i class="fa fa-times"></i>`;
                    btn.onclick = (e) => {
                        e.stopPropagation();
                        removeFile(input, index);
                        render();
                    };
                    col.appendChild(btn);
                }

                previewWrap.appendChild(col);
            });
        }
    }

    function removeFile(input, index) {
        const dt = new DataTransfer();
        Array.from(input.files).forEach((file, i) => {
            if (i !== index) dt.items.add(file);
        });
        input.files = dt.files;
    }

})();
