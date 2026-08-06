const cartItems = document.getElementById("cart-items");
console.log("cart.js TERLOAD");

let cart = JSON.parse(localStorage.getItem("cart")) || [];
updateCartBadge();

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
function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
}

// =========================
// Render Keranjang
// =========================
function renderCart() {
    cartItems.innerHTML = "";

    let total = 0;

    if (cart.length === 0) {
        cartItems.innerHTML = `
            <div class="alert alert-warning">
                Keranjang masih kosong.
            </div>
        `;

        document.getElementById("grand-total").textContent = "Rp0";
        return;
    }

    
//Event Listener Checkbox
console.log(document.querySelectorAll(".item-check"));

document.querySelectorAll(".item-check").forEach(checkbox => {
    console.log("Listener dipasang");

    checkbox.addEventListener("change", function () {
        console.log("Checkbox berubah");

        const id = Number(this.dataset.id);
        toggleSelect(id);
    });
});
console.log("Jumlah checkbox:", document.querySelectorAll(".item-check").length);


    cart.forEach(item => {
        total += item.price * item.qty;

        cartItems.innerHTML += `
            <div class="card mb-3">
                <div class="card-body">

                    <div class="row align-items-center">

                        <input type="checkbox"
                            class="form-check-input me-3 item-check"
                            data-id="${item.id}"
                            ${item.selected ? "checked" : ""}>

                        <!-- Gambar Produk -->
                        <div class="col-md-2">
                            <img
                                src="${item.image}"
                                class="img-fluid"
                                alt="${item.name}"
                            >
                        </div>

                        <!-- Informasi Produk -->
                        <div class="col-md-2">
                            <h5>${item.name}</h5>
                            <p>${item.category}</p>
                        </div>

                        <!-- Harga -->
                        <div class="col-md-2">
                            ${formatRupiah(item.price)}
                        </div>

                        <!-- Jumlah -->
                        <div class="col-md-2">
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <button
                                        class="btn btn-outline-secondary btn-sm"
                                        onclick="changeQty(${item.id}, -1)">
                                        <i class="bi bi-dash"></i>
                                    </button>

                                    <span class="mx-2 fw-bold">
                                        ${item.qty}
                                    </span>

                                    <button
                                        class="btn btn-outline-primary btn-sm"
                                        onclick="changeQty(${item.id}, 1)">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </td>
                        </div>

                        <!-- Tombol Hapus -->
                        <div class="col-md-2 text-end">
                            <button
                                class="btn"
                                onclick="removeItem(${item.id})"
                            >
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                    </div>

                </div>
            </div>
        `;
    });

    document.getElementById("grand-total").textContent = formatRupiah(total);
}

// =========================
// Jalankan Pertama Kali
// =========================
renderCart();

//Fungsi toggleSelect()
function toggleSelect(id, checked) {
    const item = cart.find(item => item.id === id);

    if (!item) return;
    item.selected = checked;

    saveCart();
    renderCart();
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

    saveCart();
    updateCartBadge();
    renderCart();
}

// =========================
// Hapus Barang
// =========================
function removeItem(id){
    const confirmDelete = confirm(
        "Yakin ingin menghapus produk ini?"
    );

    if(!confirmDelete){
        return;
    }

    cart = cart.filter (item => item.id !== id)
    saveCart();
    updateCartBadge();
    renderCart();
}

function clearCart() {
    if (cart.length === 0) {
        alert("Keranjang sudah kosong.");
    return;
    }

    const confirmClear = confirm(
        "Yakin ingin mengosongkan seluruh keranjang?"
    );

    if(!confirmClear){
        return;
    }

    cart =[];
    saveCart();
    updateCartBadge();
    renderCart();
}

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

document.addEventListener("DOMContentLoaded", () => {
    updateCartBadge();
});

// =========================
// Realtime Update Cart
// =========================
window.addEventListener("storage", () => {
    updateCartBadge();
});
