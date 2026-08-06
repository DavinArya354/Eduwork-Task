// ===============================
// ELEMENT
// ===============================
const cartItems = document.getElementById("cart-items");
const grandTotal = document.getElementById("grand-total");

// ===============================
// DATA
// ===============================
let cart = loadCart();

// ===============================
// REFRESH CART
// ===============================
function refreshCart() {
    saveCart(cart);
    updateCartBadge(cart);
    renderCart();
}

// ===============================
// RENDER CART
// ===============================
function renderCart() {
    // Selalu ambil data terbaru dari localStorage
    cart = loadCart();

    // Kosongkan isi keranjang sebelum dirender ulang
    cartItems.innerHTML = "";

    // Reset total belanja
    let total = 0;

    // ===========================
    // CART KOSONG
    // ===========================
    if (cart.length === 0) {
        cartItems.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-5">

                    <i class="bi bi-cart-x display-1 text-secondary"></i>

                    <h4 class="mt-3">
                        Keranjang Masih Kosong
                    </h4>

                    <p class="text-muted">
                        Yuk tambahkan produk terlebih dahulu.
                    </p>

                </td>
            </tr>
        `;

        grandTotal.textContent = formatRupiah(0);
        return;
    }

    // ===========================
    // MEMBUAT HTML
    // ===========================
    let html = "";

    cart.forEach(item => {

        const subtotal = item.price * item.qty;

        total += subtotal;

        html += `
            <tr>
                <td>
                    <input
                        type="checkbox"
                        class="item-check"
                        data-id="${item.id}"
                        ${item.selected ? "checked" : ""}>
                </td>

                <td>
                    <img
                        src="${item.image}"
                        alt="${item.name}"
                        width="80"
                        class="img-fluid rounded">
                </td>

                <td>
                    <h6 class="mb-1">
                        ${item.name}
                    </h6>

                    <small class="text-muted">
                        ${item.category}
                    </small>
                </td>

                <td>
                    ${formatRupiah(item.price)}
                </td>

                <td>
                    <div class="d-flex align-items-center gap-2">
                        <button
                            class="btn btn-outline-secondary btn-minus"
                            data-id="${item.id}">

                            <i class="bi bi-dash"></i>
                        </button>

                        <span>
                            ${item.qty}
                        </span>

                        <button
                            class="btn btn-outline-secondary btn-plus"
                            data-id="${item.id}">

                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </td>

                <td>
                    ${formatRupiah(subtotal)}
                </td>

                <td>
                    <button
                        class="btn btn-outline-danger btn-delete"
                        data-id="${item.id}">

                        <i class="bi bi-trash"></i>
                    </button>
                </td>

            </tr>
        `;
    });

    // Tampilkan semua HTML sekaligus
    cartItems.innerHTML = html;

    // Update total
    const selectedItems = cart.filter(item => item.selected);

    const total = selectedItems.reduce((sum, item) => {
        return sum + (item.price * item.qty);
    }, 0);

    grandTotal.textContent = formatRupiah(total);
}

// =========================
// Ubah Jumlah Barang
// =========================
function changeQty(id, change) {
    const item = cart.find(item => item.id === id);

    if (!item) return;
    item.qty += change;

    if (item.qty <= 0) {
        removeItem(id);
        return;
    }

    refreshCart();
}

// =========================
// Hapus Barang
// =========================
function removeItem(id) {
    cart = cart.filter(item => item.id !== id);
    refreshCart();
}

// =========================
// Ubah Jumlah Barang
// =========================
function toggleSelect(id, checked) {
    const item = cart.find(item => item.id === id);

    if (!item) return;
    item.selected = checked;

    refreshCart();
}

// =========================
// Clear Barang
// =========================
function clearCart() {
    if (!confirm("Kosongkan seluruh keranjang?")) {
        return;
    }
    cart = [];
    refreshCart();
}

// =========================
// Update Summary
// =========================
function updateSummary() {
    const selectedItems = cart.filter(item => item.selected);

    const total = selectedItems.reduce((sum, item) => {
        return sum + (item.price * item.qty);
    }, 0);

    grandTotal.textContent = formatRupiah(total);

}

// ===============================
// EVENT DELEGATION
// ===============================
cartItems.addEventListener("click", function (e) {
    const button = e.target.closest("button");

    if (!button) return;
    const id = Number(button.dataset.id);

    if (button.classList.contains("btn-plus")) {
        changeQty(id, 1);
    }

    else if (button.classList.contains("btn-minus")) {
        changeQty(id, -1);
    }

    else if (button.classList.contains("btn-delete")) {
        if (confirm("Yakin ingin menghapus produk ini?")) {
            removeItem(id);
        }
    }

});

cartItems.addEventListener("change", function (e) {
    if (!e.target.classList.contains("item-check")) return;

    const id = Number(e.target.dataset.id);
    toggleSelect(id, e.target.checked);
});

// =========================
// INIT
// =========================
updateCartBadge(cart);
renderCart();
