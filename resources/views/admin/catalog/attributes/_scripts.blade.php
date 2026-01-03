<script>
    (() => {
        "use strict";

        document.addEventListener("DOMContentLoaded", () => {
            initAttribute({
                label: "Size",
                formId: "sizeForm",
                modalTitleId: "sizeModalTitle",
                submitBtnId: "sizeSubmitBtn",
                idField: "sizeId",
                route: "/ecommerce/admin/attributes/sizes",
                editBtnClass: "edit-size",
                fields: {
                    name: "sizeName",
                    code: "sizeCode",
                    description: "sizeDesc",
                    status: "sizeStatus"
                },
                errors: {
                    name: "sizeNameError"
                }
            });

            initAttribute({
                label: "Color",
                formId: "colorForm",
                modalTitleId: "colorModalTitle",
                submitBtnId: "colorSubmitBtn",
                idField: "colorId",
                route: "/ecommerce/admin/attributes/colors",
                editBtnClass: "edit-color",
                fields: {
                    name: "colorName",
                    code: "colorHex",
                    status: "colorStatus"
                },
                errors: {
                    name: "colorNameError"
                }
            });

            initAttribute({
                label: "Unit",
                formId: "unitForm",
                modalTitleId: "unitModalTitle",
                submitBtnId: "unitSubmitBtn",
                idField: "unitId",
                route: "/ecommerce/admin/attributes/units",
                editBtnClass: "edit-unit",
                fields: {
                    name: "unitName",
                    symbol: "unitSymbol",
                    type: "unitType",
                    status: "unitStatus"

                },
                errors: {
                    name: "unitNameError"
                }
            });
        });

        /* ===============================
            REUSABLE ATTRIBUTE HANDLER
        =============================== */
        function initAttribute(config) {
            bindSubmit(config);
            bindEdit(config);
        }

        function bindSubmit(config) {
            const form = document.getElementById(config.formId);

            form.addEventListener("submit", function (e) {
                e.preventDefault();
                clearErrors(config);

                const formData = new FormData(form);
                const id = document.getElementById(config.idField).value;

                let url = config.route;

                if (id) {
                    url = `${config.route}/${id}`;
                    formData.append("_method", "PUT");
                }

                fetch(url, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                        "Accept": "application/json"
                    },
                    body: formData
                })
                    .then(res => {
                        if (!res.ok) throw res;
                        return res.json();
                    })
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        }
                    })
                    .catch(async err => {
                        if (err.status === 422) {
                            const res = await err.json();
                            showErrors(res.errors, config);
                        } else {
                            alert("Server error occurred!");
                        }
                    });
            });
        }

        function bindEdit(config) {
            document.querySelectorAll(`.${config.editBtnClass}`).forEach(btn => {
                btn.addEventListener("click", () => {
                    document.getElementById(config.idField).value = btn.dataset.id || "";

                    Object.keys(config.fields).forEach(key => {
                        const fieldId = config.fields[key];
                        document.getElementById(fieldId).value = btn.dataset[key] || "";
                    });

                    document.getElementById(config.modalTitleId).innerText = `Edit ${config.label}`;
                    document.getElementById(config.submitBtnId).innerText = "Update";

                    clearErrors(config);
                });
            });
        }

        function showErrors(errors, config) {
            if (errors?.name) {
                const input = document.getElementById(config.fields.name);
                const errorDiv = document.getElementById(config.errors.name);

                input.classList.add("is-invalid");
                errorDiv.innerText = errors.name[0];
            }
        }

        function clearErrors(config) {
            const input = document.getElementById(config.fields.name);
            const errorDiv = document.getElementById(config.errors.name);

            input.classList.remove("is-invalid");
            errorDiv.innerText = "";
        }
    })();
</script>