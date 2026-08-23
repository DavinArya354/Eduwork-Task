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
// Select All
// ===============================
function updateSelectAll() {
    const checkAll = document.getElementById("check-all");

    if (!checkAll) return;

    // Kalau keranjang kosong
    if (cart.length === 0) {
         checkAll.checked = false;
        return;
    }

    // Cek apakah SEMUA produk selected
    const allSelected = cart.every(item => item.selected);
    checkAll.checked = allSelected;
}

function selectAll(checked) {
    cart.forEach(item => {
        item.selected = checked;
    });
    refreshCart();
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
    let html = `<div class="cart-list">`;

    cart.forEach(item => {

        const subtotal = item.price * item.qty;

        total += subtotal;

        html += `
        <div class="cart-item">

            <!-- Checkbox -->
            <div class="cart-check">
                <input
                    type="checkbox"
                    class="form-check-input item-check"
                    data-id="${item.id}"
                    ${item.selected ? "checked" : ""}
                >
            </div>

            <!-- Gambar -->
            <div class="cart-image">
                <img
                    src="${item.image}"
                    alt="${item.name}"
                    class="img-fluid">
            </div>

            <!-- Informasi -->
            <div class="cart-info">
                <h5>${item.name}</h5>
                <p class="text-muted mb-2">
                    ${item.category}
                </p>

                <div class="fw-semibold text-dark">
                    ${formatRupiah(item.price)}
                </div>

                <div class="qty-box mt-3">
                    <button
                        class="btn btn-minus"
                        data-id="${item.id}">
                        <i class="bi bi-dash"></i>
                    </button>

                    <span>${item.qty}</span>

                    <button
                        class="btn btn-plus"
                        data-id="${item.id}">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
            </div>

            <!-- Bagian kanan -->
            <div class="cart-action">
                <div class="subtotal-title">
                    Subtotal
                </div>

                <div class="subtotal-price">
                    ${formatRupiah(subtotal)}
                </div>
                
                <button
                    class="btn btn-outline-danger btn-delete mt-3"
                    data-id="${item.id}">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

        </div>
        `;
    });

    // Tampilkan semua HTML sekaligus
    html += `</div>`;
    cartItems.innerHTML = html;

    // Update total
    const selectedItems = cart.filter(item => item.selected);
    grandTotal.textContent = formatRupiah(total);
    updateSummary();
    updateSelectAll();
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
    updateSelectAll();
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
function updateSummary(){
    const selectedItems = cart.filter(item => item.selected);

    const selectedCount = selectedItems.length;

    const totalQty = selectedItems.reduce((sum,item)=>{
        return sum + item.qty;
    },0);

    const totalPrice = selectedItems.reduce((sum,item)=>{
        return sum + (item.qty * item.price);
    },0);

    document.getElementById("selected-count").textContent = selectedCount;
    document.getElementById("selected-qty").textContent = totalQty;
    grandTotal.textContent = formatRupiah(totalPrice);
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

document.getElementById("check-all").addEventListener("change", function () {
    selectAll(this.checked);
});

// =========================
// INIT
// =========================
updateCartBadge(cart);
renderCart();
