function loadCart() {
    return JSON.parse(localStorage.getItem("cart")) || [];
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

// =========================
// Simpan Keranjang
// =========================
function saveCart(cart) {
    localStorage.setItem("cart", JSON.stringify(cart));
}

// =========================
// Fungsi Update Cart
// =========================
function updateCartBadge(cart) {
    const badge = document.getElementById("cart-count");

    if (!badge) return;

    const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);

    badge.textContent = totalQty;

    badge.style.display = totalQty > 0 ? "flex" : "none";
}

document.addEventListener("DOMContentLoaded", () => {
    updateCartBadge();
});
