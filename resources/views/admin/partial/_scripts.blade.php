<script>
    (() => {
        "use strict";

        document.addEventListener("DOMContentLoaded", init);

        function init() {
            generateSku();
        }

     

        function generateSku() {
            document.querySelectorAll('.generate-sku-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const skuField = document.querySelector('input[name="sku"]');
                    if (!skuField) return;

                    if (skuField.value.trim() !== '') {
                        if (!confirm('SKU already exists. Generate new one?')) return;
                    }

                    const year = new Date().getFullYear();
                    const random = Math.random().toString(36).substr(2, 6).toUpperCase();
                    skuField.value = `PRD-${year}-${random}`;
                });
            });
        }
    })();
</script>