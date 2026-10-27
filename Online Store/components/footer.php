<?php
require_once __DIR__ . "/../config/app.php";

$isStoreFooter = ($storeLayout ?? false) === true 
    || (($_GET["component"] ?? "") === "footer"); 

// Jika $isStoreFooter bernilai true, maka footer khusus untuk tampilan toko akan ditampilkan. Jika tidak, footer umum akan ditampilkan.
if ($isStoreFooter) {
    ?>
    <footer class="custom-footer text-white mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="h5 fw-bold">ArcticStore</h2>
                    <p class="mb-0">
                        Temukan produk pilihan untuk kebutuhan sehari-hari.
                    </p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <a href="<?= htmlspecialchars(BASE_URL . "user/home.html", ENT_QUOTES, "UTF-8") ?>" class="footer-link">Home</a>
                    <a href="<?= htmlspecialchars(BASE_URL . "user/home.html#product-list", ENT_QUOTES, "UTF-8") ?>" class="footer-link">Produk</a>
                    <a href="<?= htmlspecialchars(BASE_URL . "user/cart.php", ENT_QUOTES, "UTF-8") ?>" class="footer-link">Keranjang</a>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <small>&copy; <?= date("Y") ?> ArcticStore | E-Commerce</small>
            </div>
        </div>
    </footer>
    <?php
    return;
}
?>
</main>

<!-- ================= FOOTER ================= -->

<footer class="custom-footer text-white mt-5">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-6">
                <h5 class="fw-bold">Arctic Store</h5>
                <p class="mb-0">
                    Simple e-commerce project built with PHP,
                    MySQL, Bootstrap, and JavaScript.
                </p>
            </div>

            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="<?= BASE_URL ?>user/home.html" class="footer-link">Home</a>
                <a href="<?= BASE_URL ?>product/crud/product-read.php" class="footer-link">
                    Products
                </a>
                <a href="#" class="footer-link">Contact</a>
            </div>
        </div>

        <hr>

        <div class="text-center">
            <small>
                &copy; <?= date("Y") ?> Arctic Store.
                All rights reserved.
            </small>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>
<script>
    const productTable = document.querySelector('#productTable');

    if (productTable) {
        new DataTable('#productTable', {
            paging: true,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            layout: {
                topStart: 'pageLength',
                topEnd: 'search',
                bottomStart: 'info',
                bottomEnd: 'paging'
            },
            columnDefs: [
                { targets: [0, 1, 6, 7], orderable: false },
                { targets: [1, 7], searchable: false }
            ],
            language: {
                search: 'Search:',
                lengthMenu: 'Show _MENU_ products',
                info: 'Showing _START_ to _END_ of _TOTAL_ products',
                infoEmpty: 'No products available',
                zeroRecords: 'No matching products found',
                paginate: {
                    first: 'First',
                    last: 'Last',
                    previous: 'Previous',
                    next: 'Next'
                }
            }
        });

        const controls = document.querySelector('#dataTable-controls');
        const lengthControl = document.querySelector(
            '#productTable_wrapper .dt-length'
        );
        const searchControl = document.querySelector(
            '#productTable_wrapper .dt-search'
        );

        if (controls && lengthControl && searchControl) {
            controls.appendChild(lengthControl);
            controls.appendChild(searchControl);
        }

        document.querySelectorAll(
            '#productTable_wrapper .dt-layout-row'
        ).forEach(row => {
            if (
                !row.querySelector(
                    '.dt-length, .dt-search, .dt-info, .dt-paging'
                )
            ) {
                row.remove();
            }
        });
    }
</script>

</body>
</html>
