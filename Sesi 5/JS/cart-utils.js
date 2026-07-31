let cart = loadCart();

function loadCart() {
    return JSON.parse(localStorage.getItem("cart")) || [];
}

function getCart() {
    return JSON.parse(localStorage.getItem("cart")) || [];
}

function setCart(cart) {
    localStorage.setItem("cart", JSON.stringify(cart));
}

let cart = getCart();

// ubah isi cart

setCart(cart);
updateCartBadge();

// =========================
// Simpan Keranjang
// =========================
function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
}

let cart = JSON.parse(localStorage.getItem("cart")) || [];
updateCartBadge();


// =========================
// Fungsi Update Cart
// =========================
function updateCartBadge() {
    const badge = document.getElementById("cart-count");

    if (!badge) return;

    const cart = JSON.parse(localStorage.getItem("cart")) || [];

    const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);

    badge.textContent = totalQty;

    badge.style.display = totalQty > 0 ? "flex" : "none";
}

// =========================
// Format Rupiah
// =========================
function formatRupiah(number) {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR"
    }).format(number);
}
