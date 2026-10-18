const cartForm = document.getElementById("cart-form");
const checkAll = document.getElementById("check-all");
const clearCartForm = document.getElementById("clear-cart-form");

// Mengirim pilihan checkbox produk agar disimpan ke session PHP.
function submitCartSelection() {
    if (cartForm) {
        cartForm.requestSubmit();
    }
}

// Menyimpan perubahan pilihan pada satu produk.
function handleItemSelectionChange() {
    submitCartSelection();
}

// Menyamakan pilihan produk dengan status checkbox pilih semua.
function setItemSelection(checkbox) {
    checkbox.checked = checkAll.checked;
}

// Memilih atau membatalkan pilihan semua produk lalu menyimpan perubahan.
function handleSelectAllChange() {
    document.querySelectorAll(".item-check").forEach(setItemSelection);
    submitCartSelection();
}

// Membatalkan penghapusan produk bila konfirmasi pengguna ditolak.
function confirmItemRemoval(event) {
    if (!window.confirm("Yakin ingin menghapus produk ini?")) {
        event.preventDefault();
    }
}

// Membatalkan pengosongan keranjang bila konfirmasi pengguna ditolak.
function confirmCartClear(event) {
    if (!window.confirm("Kosongkan seluruh keranjang?")) {
        event.preventDefault();
    }
}

document.querySelectorAll(".item-check").forEach(function (checkbox) {
    checkbox.addEventListener("change", handleItemSelectionChange);
});

document.querySelectorAll(".btn-delete").forEach(function (button) {
    button.addEventListener("click", confirmItemRemoval);
});

// Menyimpan perubahan pilihan produk saat checkbox pilih semua diubah.
if (checkAll) {
    checkAll.addEventListener("change", handleSelectAllChange);
}

// Mengonfirmasi pengosongan keranjang
if (clearCartForm) {
    clearCartForm.addEventListener("submit", confirmCartClear);
}
