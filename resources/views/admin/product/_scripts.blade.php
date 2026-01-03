<script>
    (() => {
        "use strict";

        document.addEventListener("DOMContentLoaded", init);

        function init() {
            byCategory();
        }

        function byCategory() {
            const category = document.getElementById('category-select');
            const subCategorySelect = document.querySelector('select[name="sub_category_id"]');

            if (!category || !subCategorySelect) return;

            category.addEventListener('change', function () {
                const categoryId = this.value;

                subCategorySelect.innerHTML = '<option>Loading...</option>';
                subCategorySelect.disabled = true;

                if (!categoryId) {
                    subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
                    subCategorySelect.disabled = false;
                    return;
                }

                fetch(`/ecommerce/admin/sub-category/by-category/${categoryId}`)
                    .then(res => res.json())
                    .then(data => {
                        subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
                        data.subCategories.forEach(sub => {
                            const option = document.createElement('option');
                            option.value = sub.id;
                            option.textContent = sub.name;
                            subCategorySelect.appendChild(option);
                        });
                        subCategorySelect.disabled = false;
                    })
                    .catch(err => {
                        console.error(err);
                        subCategorySelect.innerHTML = '<option>Error loading</option>';
                        subCategorySelect.disabled = false;
                    });
            });
        }
    })();
</script>