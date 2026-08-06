// ===============================
// ELEMENT
// ===============================

const productList = document.getElementById("product-list");
const productCount = document.getElementById("product-count");

const searchInput = document.getElementById("searchInput");
const categoryFilter = document.getElementById("categoryFilter");
const priceFilter = document.getElementById("priceFilter");
const sortFilter = document.getElementById("sortFilter");

// ===============================
// FORMAT RUPIAH
// ===============================

function formatRupiah(number) {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR"
    }).format(number);
}

// ===============================
// MEMBUAT CARD PRODUK
// ===============================

function createProductCard(product) {
    return `
        <div class="col-sm-6 col-lg-4">
            <div class="card product-card h-100 shadow-sm">
                <img
                    src="${product.image}"
                    class="card-img-top"
                    alt="${product.name}">

                <div class="card-body d-flex flex-column">
                    <span class="badge bg-primary mb-2">
                        ${product.category}
                    </span>

                    <h5 class="card-title">
                        ${product.name}
                    </h5>

                    <p class="card-text text-muted flex-grow-1">
                        ${product.description}
                    </p>

                    <h4 class="text-primary fw-bold">
                        ${formatRupiah(product.price)}
                    </h4>

                    <button
                        class="btn btn-warning w-100 mt-3"
                        onclick="addToCart(${product.id})">

                        <i class="bi bi-cart-plus"></i>
                        Tambah ke Keranjang
                    </button>
                </div>

            </div>
        </div>
    `;
}

// ===============================
// RENDER PRODUK
// ===============================

function renderProducts(productArray) {
    productList.innerHTML = "";

    if (productArray.length === 0) {
        productList.innerHTML = `
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Produk tidak ditemukan.
                </div>
            </div>
        `;

        productCount.textContent = "0 Produk";
        return;
    }

    productArray.forEach(product => {
        productList.innerHTML += createProductCard(product);
    });

    productCount.textContent = `${productArray.length} Produk`;
}

// ===============================
// LOAD
// ===============================

renderProducts(products);

function filterProducts() {

    let filtered = [...products];

    // ===========================
    // SEARCH
    // ===========================

    const keyword = searchInput.value.toLowerCase().trim();
        if (keyword !== "") {
            filtered = filtered.filter(product => {
                const keywords = product.keywords
                    ? product.keywords.join(" ").toLowerCase()
                    : "";

                return (
                    product.name.toLowerCase().includes(keyword) ||
                    product.description.toLowerCase().includes(keyword) ||
                    product.category.toLowerCase().includes(keyword) ||
                    keywords.includes(keyword)
                );
            });
        }

    // ===========================
    // CATEGORY
    // ===========================

    if (categoryFilter.value !== "Semua") {
        filtered = filtered.filter(product =>
            product.category === categoryFilter.value
        );
    }

    // ===========================
    // PRICE
    // ===========================

    switch (priceFilter.value) {
        case "0-500000":
            filtered = filtered.filter(product => product.price < 500000);
            break;

        case "500000-2000000":
            filtered = filtered.filter(product =>
                product.price >= 500000 &&
                product.price <= 2000000
            );
            break;

        case "2000000-5000000":
            filtered = filtered.filter(product =>
                product.price > 2000000 &&
                product.price <= 5000000
            );
            break;

        case "5000000+":
            filtered = filtered.filter(product =>
                product.price > 5000000
            );
            break;
    }

    // ===========================
    // SORT
    // ===========================

    switch (sortFilter.value) {
        case "low-high":
            filtered.sort((a, b) => a.price - b.price);
            break;

        case "high-low":
            filtered.sort((a, b) => b.price - a.price);
            break;

        case "az":
            filtered.sort((a, b) =>
                a.name.localeCompare(b.name)
            );
            break;

        case "za":
            filtered.sort((a, b) =>
                b.name.localeCompare(a.name)
            );
            break;
    }

    renderProducts(filtered);

}

searchInput.addEventListener("input", filterProducts);
categoryFilter.addEventListener("change", filterProducts);
priceFilter.addEventListener("change", filterProducts);
sortFilter.addEventListener("change", filterProducts);

// ===============================
// CART
// ===============================

let cart = JSON.parse(localStorage.getItem("cart")) || [];

cart = cart.map(item => ({
    ...item,
    selected: item.selected ?? true
}));
saveCart();
updateCartBadge();

function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
}

function updateCartBadge() {
    const badge = document.getElementById("cart-count");

    const totalQty = cart.reduce((total, item) => {
        return total + item.qty;
    }, 0);

    badge.textContent = totalQty;
}

function addToCart(productId) {
    const product = products.find(p => p.id === productId);

    const item = cart.find(item => item.id === productId);

    if (item) {
        item.qty++;
    } else {
        cart.push({
            ...product,
            qty: 1,
            selected: true
        });
    }

    saveCart();
    updateCartBadge();
    alert(product.name + " berhasil ditambahkan.");
}

updateCartBadge();
