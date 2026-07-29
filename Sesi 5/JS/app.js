// ===============================
// ELEMENT
// ===============================

const productList = document.getElementById("product-list");
const productCount = document.getElementById("product-count");

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
                        class="btn btn-warning w-100 mt-3">

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

    productArray.forEach(product => {
        productCount.textContent = `${productArray.length} Produk`;

        productList.innerHTML += createProductCard(product);

    });

}

// ===============================
// LOAD
// ===============================

renderProducts(products);
