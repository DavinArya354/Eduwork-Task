const productList = document.getElementById("product-list"); // Mengambil elemen yang menampung card produk.
let searchInput = null; // Kolom pencarian tersedia setelah navbar dimuat.
const categoryFilter = document.getElementById("categoryFilter"); // Mengambil pilihan kategori.
const priceFilter = document.getElementById("priceFilter"); // Mengambil pilihan rentang harga.
const sortFilter = document.getElementById("sortFilter"); // Mengambil pilihan pengurutan.

const productCount = document.getElementById("product-count"); // Mengambil label jumlah produk.
let cartCount = null; // Label jumlah barang tersedia setelah navbar dimuat.

const loadingProducts = document.getElementById("loading-products"); // Mengambil pesan saat produk sedang dimuat.
const emptyProducts = document.getElementById("empty-products"); // Mengambil pesan jika katalog kosong.
const emptyFilterResults = document.getElementById("empty-filter-results"); // Mengambil pesan jika hasil filter kosong.
const loadError = document.getElementById("load-error"); // Mengambil pesan jika data produk gagal dimuat.

const headerContainer = document.getElementById("store-header"); // Mengambil tempat untuk navbar bersama.
const footerContainer = document.getElementById("store-footer"); // Mengambil tempat untuk footer bersama.
const productItems = []; // Menyimpan seluruh card produk untuk proses filter dan pengurutan.
const rupiahFormatter = new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR", maximumFractionDigits: 0 }); // Menyiapkan format harga rupiah.

async function loadStoreComponents() { // Memuat navbar dan footer bersama dari komponen PHP.
    const components = [ // Menentukan komponen bersama yang perlu dimuat.
        { url: "../components/header.php?component=header&active=home", target: headerContainer }, // Menyiapkan endpoint navbar bersama.
        { url: "../components/footer.php?component=footer", target: footerContainer } // Menyiapkan endpoint footer bersama.
    ]; // Menutup daftar komponen.
    await Promise.all(components.map(async function (component) { // Memuat kedua komponen secara bersamaan.
        const response = await fetch(component.url, { headers: { Accept: "text/html" } }); // Meminta markup komponen dari server.
        if (!response.ok) { // Memeriksa apakah endpoint komponen berhasil.
            throw new Error("Komponen gagal dimuat: " + component.url + " (" + response.status + ")"); // Menjelaskan kesalahan endpoint.
        } // Menutup pemeriksaan status respons.
        component.target.innerHTML = await response.text(); // Menyisipkan markup komponen ke halaman.
    })); // Menutup pemuatan semua komponen.
} // Menutup fungsi pemuatan komponen bersama.

function createElement(tagName, className, text) { // Membuat elemen HTML dengan kelas dan teks yang aman.
    const element = document.createElement(tagName); // Membuat elemen sesuai nama tag.
    element.className = className; // Mengatur kelas CSS elemen.
    if (text !== undefined) { // Memeriksa apakah elemen perlu diisi teks.
        element.textContent = text; // Mengisi teks tanpa menafsirkan HTML.
    } // Menutup pemeriksaan teks.
    return element; // Mengembalikan elemen yang sudah dibuat.
} // Menutup fungsi pembuatan elemen.

function createProductcard(product) { // Membuat card produk berdasarkan data dari server.
    const column = createElement("div", "col-6 col-sm-4 product-item"); // Membuat kolom Bootstrap untuk card.
    column.dataset.name = product.name; // Menyimpan nama untuk pencarian.
    column.dataset.category = product.category; // Menyimpan kategori untuk filter.
    column.dataset.description = product.description; // Menyimpan deskripsi untuk pencarian.
    column.dataset.price = String(product.price); // Menyimpan harga untuk filter dan pengurutan.
    const card = createElement("article", "card product-card h-100 shadow-sm"); // Membuat card produk.

    if (product.image) { // Memeriksa apakah produk memiliki gambar.
        const image = createElement("img", "card-img-top"); // Membuat elemen gambar produk.
        image.src = product.image;
        image.alt = product.name;
        image.loading = "lazy"; // Menunda pemuatan gambar sampai mendekati area tampilan.
        card.appendChild(image); // Menambahkan gambar ke card.
    } else { // Menangani produk yang tidak memiliki gambar.
        const placeholder = createElement("div", "card-img-top d-flex align-items-center justify-content-center bg-light text-secondary"); // Membuat area pengganti gambar.
        placeholder.setAttribute("role", "img"); // Menandai area sebagai gambar bagi pembaca layar.
        placeholder.setAttribute("aria-label", "Gambar produk tidak tersedia");
        placeholder.appendChild(createElement("i", "bi bi-image fs-1"));
        card.appendChild(placeholder); // Menambahkan pengganti gambar ke card.
    } // Menutup pemeriksaan gambar.
    
    const body = createElement("div", "card-body d-flex flex-column"); // Membuat bagian isi card.
    body.appendChild(createElement("span", "product-category mb-2", product.category)); // Menampilkan kategori produk.
    body.appendChild(createElement("h3", "h5 card-title", product.name)); // Menampilkan nama produk.
    body.appendChild(createElement("p", "small text-muted mb-1", product.stock > 0 ? "Stok: " + product.stock : "Stok habis")); // Menampilkan ketersediaan stok.
    body.appendChild(createElement("h4", "product-price fw-bold", rupiahFormatter.format(product.price))); // Menampilkan harga dalam format rupiah.

    const detailLink = createElement("a", "btn btn-primary w-100 mt-3", "Detail Produk"); // Membuat tautan menuju detail produk.
    detailLink.href = "../product/product-detail.php?id=" + encodeURIComponent(product.id); // Mengatur alamat halaman detail produk.
    const detailIcon = createElement("i", "bi bi-eye me-1"); // Membuat ikon detail produk.
    detailIcon.setAttribute("aria-hidden", "true"); // Menyembunyikan ikon dekoratif dari pembaca layar.
    detailLink.prepend(detailIcon); // Menambahkan ikon sebelum teks tautan.
    body.appendChild(detailLink); // Menambahkan tautan detail ke card.

    const form = createElement("form", ""); // Membuat formulir penambahan ke keranjang.
    form.method = "post"; // Mengirim data formulir dengan metode POST.
    form.action = "cart.php"; // Mengirim formulir ke penangan keranjang.
    const actionInput = createElement("input", ""); // Membuat input tersembunyi untuk jenis tindakan.
    actionInput.type = "hidden"; // Menyembunyikan input tindakan dari tampilan.
    actionInput.name = "action"; // Mengatur nama input tindakan.
    actionInput.value = "add_to_cart"; // Mengatur tindakan untuk menambah produk.
    form.appendChild(actionInput); // Menambahkan input tindakan ke formulir.
    const productInput = createElement("input", ""); // Membuat input tersembunyi untuk ID produk.
    productInput.type = "hidden"; // Menyembunyikan input ID produk dari tampilan.
    productInput.name = "product_id"; // Mengatur nama input ID produk.
    productInput.value = String(product.id); // Mengisi ID produk yang akan ditambahkan.
    form.appendChild(productInput); // Menambahkan input ID produk ke formulir.

    const addButton = createElement("button", "btn btn-warning w-100 mt-3", "Tambah ke Keranjang"); // Membuat tombol tambah ke keranjang.
    addButton.type = "submit"; // Menetapkan tombol untuk mengirim formulir.
    addButton.disabled = product.stock < 1; // Menonaktifkan tombol jika stok habis.
    const cartIcon = createElement("i", "bi bi-cart-plus me-1"); // Membuat ikon keranjang.
    cartIcon.setAttribute("aria-hidden", "true"); // Menyembunyikan ikon dekoratif dari pembaca layar.
    addButton.prepend(cartIcon); // Menambahkan ikon sebelum teks tombol.
    form.appendChild(addButton); // Menambahkan tombol ke formulir.
    body.appendChild(form); // Menambahkan formulir ke card.
    card.appendChild(body); // Menambahkan isi card ke card produk.
    column.appendChild(card); // Menambahkan card ke kolom Bootstrap.
    return column; // Mengembalikan kolom produk yang telah selesai.
} // Menutup fungsi pembuat card produk.

function filterProducts() { // Memfilter, mengurutkan, dan menampilkan card produk.
    const keyword = (searchInput ? searchInput.value : "").trim().toLocaleLowerCase("id"); // Menyiapkan kata kunci pencarian.
    const selectedCategory = categoryFilter.value;
    const selectedPrice = priceFilter.value;

    const visibleProducts = productItems.filter(function (item) { // Memilih card yang sesuai dengan semua filter.
        const text = [item.dataset.name, item.dataset.description, item.dataset.category].join(" ").toLocaleLowerCase("id"); // Menggabungkan teks yang dapat dicari.
        const price = Number(item.dataset.price); // Mengubah harga card menjadi angka.
        const matchesSearch = text.includes(keyword); // Memeriksa kecocokan kata kunci.
        const matchesCategory = selectedCategory === "Semua" || item.dataset.category === selectedCategory; // Memeriksa kecocokan kategori.
        let matchesPrice = true; // Menganggap harga cocok sebelum rentang diperiksa.

        if (selectedPrice === "0-500000") { // Memeriksa rentang harga di bawah Rp500.000.
            matchesPrice = price < 500000; // Mencocokkan harga di bawah batas pertama.
        } else if (selectedPrice === "500000-2000000") { // Memeriksa rentang Rp500.000 sampai Rp2.000.000.
            matchesPrice = price >= 500000 && price <= 2000000; // Mencocokkan harga di dalam rentang kedua.
        } else if (selectedPrice === "2000000-5000000") { // Memeriksa rentang di atas Rp2.000.000 sampai Rp5.000.000.
            matchesPrice = price > 2000000 && price <= 5000000; // Mencocokkan harga di dalam rentang ketiga.
        } else if (selectedPrice === "5000000+") { // Memeriksa rentang harga di atas Rp5.000.000.
            matchesPrice = price > 5000000; // Mencocokkan harga yang melewati batas tertinggi.
        } // Menutup pemilihan rentang harga.
        return matchesSearch && matchesCategory && matchesPrice; // Mengembalikan status kecocokan semua filter.
    }); // Menutup pemfilteran card produk.

    const sortOrder = sortFilter.value; // Membaca urutan yang dipilih.

    if (sortOrder === "low-high") { // Memeriksa apakah harga harus diurutkan dari rendah.
        visibleProducts.sort(function (a, b) { return Number(a.dataset.price) - Number(b.dataset.price); }); // Mengurutkan harga dari rendah ke tinggi.
    } else if (sortOrder === "high-low") { // Memeriksa apakah harga harus diurutkan dari tinggi.
        visibleProducts.sort(function (a, b) { return Number(b.dataset.price) - Number(a.dataset.price); }); // Mengurutkan harga dari tinggi ke rendah.
    } else if (sortOrder === "az") { // Memeriksa apakah nama harus diurutkan A-Z.
        visibleProducts.sort(function (a, b) { return a.dataset.name.localeCompare(b.dataset.name, "id"); }); // Mengurutkan nama secara alfabetis.
    } else if (sortOrder === "za") { // Memeriksa apakah nama harus diurutkan Z-A.
        visibleProducts.sort(function (a, b) { return b.dataset.name.localeCompare(a.dataset.name, "id"); }); // Mengurutkan nama secara alfabetis terbalik.
    } // Menutup pemilihan aturan pengurutan.

    productItems.forEach(function (item) { item.classList.toggle("d-none", !visibleProducts.includes(item)); }); // Menampilkan hanya card yang cocok.
    productCount.textContent = visibleProducts.length + " Produk"; // Memperbarui jumlah hasil yang terlihat.
    emptyFilterResults.classList.toggle("d-none", visibleProducts.length !== 0 || productItems.length === 0); // Menampilkan pesan jika filter tidak menemukan hasil.
    visibleProducts.forEach(function (item) { productList.appendChild(item); }); // Menata ulang card sesuai urutan hasil.
    productList.appendChild(emptyProducts); // Menjaga pesan katalog kosong tetap berada di dalam daftar.
    productList.appendChild(emptyFilterResults); // Menjaga pesan filter tetap berada di dalam daftar.
} // Menutup fungsi filter dan pengurutan produk.

// Meminta data katalog dari endpoint PHP.
async function loadProducts() {
    // Memulai penanganan kegagalan permintaan.
    try {
        const response = await fetch("home.php", { headers: { Accept: "application/json" } }); // Meminta data produk dari endpoint.
        if (!response.ok) { // Memeriksa apakah server menjawab dengan status sukses.
            throw new Error("Server menjawab dengan status " + response.status); // Menghasilkan kesalahan yang menjelaskan status server.
        } // Menutup pemeriksaan status respons.
        const data = await response.json(); // Membaca respons JSON dari server.

        if (!Array.isArray(data.products) || !Array.isArray(data.categories)) { // Memastikan struktur data sesuai harapan.
            throw new Error("Format data produk dari server tidak valid."); // Menghasilkan kesalahan jika data tidak sesuai.
        } // Menutup pemeriksaan struktur data.

        data.categories.forEach(function (category) { // Menambahkan setiap kategori ke pilihan filter.
            const option = createElement("option", "", category); // Membuat pilihan kategori dengan teks aman.
            option.value = category; // Mengatur nilai pilihan kategori.
            categoryFilter.appendChild(option); // Menambahkan pilihan kategori ke daftar.
        }); // Menutup penambahan kategori.

        data.products.forEach(function (product) { // Membuat card untuk setiap produk dari server.
            const item = createProductcard(product); // Membuat satu card produk.
            productItems.push(item); // Menyimpan card untuk fungsi filter.
            productList.insertBefore(item, loadingProducts); // Menampilkan card sebelum pesan pemuatan.
        }); // Menutup pembuatan card produk.
        loadingProducts.remove(); // Menghapus pesan pemuatan setelah data tersedia.
        emptyProducts.classList.toggle("d-none", data.products.length !== 0); // Menampilkan pesan jika katalog memang kosong.


        if (cartCount) { // Memeriksa apakah navbar berhasil menyediakan label keranjang.
            cartCount.textContent = String(Number(data.cartCount) || 0); // Menampilkan jumlah barang di keranjang.
        } // Menutup pemeriksaan label keranjang.
        filterProducts(); // Menerapkan filter awal dan memperbarui jumlah produk.
        
    } catch (error) { // Menangani kesalahan jaringan atau data server.
        console.error("Gagal memuat produk:", error); // Mencatat rincian kesalahan untuk pemeriksaan.
        loadingProducts.remove(); // Menghapus pesan pemuatan yang sudah tidak relevan.
        loadError.classList.remove("d-none"); // Menampilkan pesan kegagalan kepada pengguna.
    } // Menutup penanganan permintaan.
} // Menutup fungsi pemuatan produk.

categoryFilter.addEventListener("change", filterProducts); // Memfilter ulang saat kategori berubah.
priceFilter.addEventListener("change", filterProducts); // Memfilter ulang saat rentang harga berubah.
sortFilter.addEventListener("change", filterProducts); // Mengurutkan ulang saat pilihan pengurutan berubah.

loadStoreComponents().then(function () { // Menyiapkan pencarian setelah navbar disisipkan.
    searchInput = document.getElementById("searchInput"); // Mengambil kolom pencarian dari navbar.
    cartCount = document.getElementById("cart-count"); // Mengambil label jumlah barang dari navbar.

    // Memastikan navbar toko menyediakan kolom pencarian.
    if (!searchInput) { 
        throw new Error("Kolom pencarian tidak ditemukan di navbar."); // Melaporkan markup navbar yang tidak sesuai.
    } // Menutup pemeriksaan kolom pencarian.
    searchInput.addEventListener("input", filterProducts); // Memfilter ulang saat pengguna mengetik.
}).catch(function (error) { // Memuat komponen dan menangani kegagalannya.
    console.error("Gagal memuat navbar atau footer:", error); // Mencatat rincian kegagalan komponen.
    [headerContainer, footerContainer].forEach(function (container) { // Menyampaikan status pemuatan yang gagal di kedua tempat.
        container.textContent = "Komponen navigasi belum dapat dimuat."; // Menampilkan pesan agar kegagalan tidak tersembunyi.
        container.classList.add("alert", "alert-warning", "m-0"); // Menandai pesan kegagalan secara visual.
    }); // Menutup penanganan tiap tempat komponen.

    // Tetap memuat produk walaupun komponen bersama gagal.
}).finally(function () { 
    loadProducts(); // Memulai pemuatan katalog setelah komponen selesai dimuat.
}); // Menutup penanganan kegagalan komponen.
