</main>

<!-- ================= FOOTER ================= -->

<footer class="custom-footer text-white mt-5">
<div class="container py-4">

    <div class="row">
        <div class="col-md-6">
            <h5 class="fw-bold">
                Arctic Store
            </h5>

            <p class="mb-0">
                Simple e-commerce project built with PHP,
                MySQL, Bootstrap, and JavaScript.
            </p>
        </div>

        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="#" class="footer-link">
                Home
            </a>

            <a href="product-read.php" class="footer-link">
                Products
            </a>

            <a href="#" class="footer-link">
                Contact
            </a>
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

<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>

<script>
    console.log("Footer loaded");

    console.log("productTable:",
        document.querySelector("#productTable")
    );

    console.log("DataTable:",
        typeof DataTable
    );

    new DataTable('#productTable', {
        paging: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],

        columnDefs: [
            {
                targets: [0, 1, 6, 7],
                orderable: false
            },
            {
                targets: [1, 7],
                searchable: false
            }
        ],

        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ products",
            info: "Showing _START_ to _END_ of _TOTAL_ products",
            infoEmpty: "No products available",
            zeroRecords: "No matching products found",

            paginate: {
                first: "First",
                last: "Last",
                previous: "Previous",
                next: "Next"
            }
        }
    });
</script>

</body>
</html>
