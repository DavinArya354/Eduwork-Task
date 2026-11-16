const productList = document.getElementById("product-list");
const searchInput = document.getElementById("searchInput");
const categoryFilter = document.getElementById("categoryFilter");
const priceFilter = document.getElementById("priceFilter");
const sortFilter = document.getElementById("sortFilter");
const emptyFilterResults = document.getElementById("empty-filter-results");
const productItems = Array.from(document.querySelectorAll(".product-item"));

function filterProducts() {
    const keyword = searchInput.value.trim().toLocaleLowerCase("id");
    const selectedCategory = categoryFilter.value;
    const selectedPrice = priceFilter.value;
    const visibleProducts = productItems.filter((item) => {
        const text = [
            item.dataset.name,
            item.dataset.description,
            item.dataset.category,
        ].join(" ").toLocaleLowerCase("id");
        const price = Number(item.dataset.price);
        const matchesSearch = text.includes(keyword);
        const matchesCategory = selectedCategory === "Semua"
            || item.dataset.category === selectedCategory;
        let matchesPrice = true;

        if (selectedPrice === "0-500000") {
            matchesPrice = price < 500000;
        } else if (selectedPrice === "500000-2000000") {
            matchesPrice = price >= 500000 && price <= 2000000;
        } else if (selectedPrice === "2000000-5000000") {
            matchesPrice = price > 2000000 && price <= 5000000;
        } else if (selectedPrice === "5000000+") {
            matchesPrice = price > 5000000;
        }

        return matchesSearch && matchesCategory && matchesPrice;
    });

    const sortOrder = sortFilter.value;
    if (sortOrder === "low-high") {
        visibleProducts.sort((a, b) => Number(a.dataset.price) - Number(b.dataset.price));
    } else if (sortOrder === "high-low") {
        visibleProducts.sort((a, b) => Number(b.dataset.price) - Number(a.dataset.price));
    } else if (sortOrder === "az") {
        visibleProducts.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name, "id"));
    } else if (sortOrder === "za") {
        visibleProducts.sort((a, b) => b.dataset.name.localeCompare(a.dataset.name, "id"));
    }

    productItems.forEach((item) => item.classList.toggle("d-none", !visibleProducts.includes(item)));
    emptyFilterResults.classList.toggle(
        "d-none",
        visibleProducts.length !== 0 || productItems.length === 0,
    );
    visibleProducts.forEach((item) => productList.insertBefore(item, emptyFilterResults));
}

searchInput.addEventListener("input", filterProducts);
categoryFilter.addEventListener("change", filterProducts);
priceFilter.addEventListener("change", filterProducts);
sortFilter.addEventListener("change", filterProducts);
filterProducts();
