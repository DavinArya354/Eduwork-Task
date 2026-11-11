<footer class="custom-footer bg-dark text-light pt-5 pb-3">
	<div class="container">
		<div class="row g-4">
			<div class="col-12 col-md-6 col-lg-4">
				<a href="{{ url('/') }}" class="text-decoration-none text-white fw-bold fs-4">ArcticStore</a>
				<p class="text-white-50 mt-3 mb-0">
					Temukan produk pilihan untuk kebutuhan sehari-hari.
				</p>
			</div>

			<div class="col-6 col-md-3 col-lg-2">
				<h2 class="h6 text-uppercase fw-bold">Navigasi</h2>
				<ul class="list-unstyled mb-0">
					<li class="mb-2"><a href="{{ url('/') }}" class="link-light link-opacity-75-hover text-decoration-none">Home</a></li>
					<li class="mb-2"><a href="{{ url('/#product-list') }}" class="link-light link-opacity-75-hover text-decoration-none">Produk</a></li>
					<li><a href="{{ route('cart.page') }}" class="link-light link-opacity-75-hover text-decoration-none">Keranjang</a></li>
				</ul>
			</div>

			<div class="col-6 col-md-3 col-lg-3">
				<h2 class="h6 text-uppercase fw-bold">Bantuan</h2>
				<ul class="list-unstyled mb-0">
					<li class="mb-2"><a href="{{ route('checkout.page') }}" class="link-light link-opacity-75-hover text-decoration-none">Checkout</a></li>
					<li class="mb-2"><a href="{{ route('cart.page') }}" class="link-light link-opacity-75-hover text-decoration-none">Keranjang</a></li>
					<li><a href="#top" class="link-light link-opacity-75-hover text-decoration-none">Kembali ke atas</a></li>
				</ul>
			</div>

			<div class="col-12 col-lg-3">
				<h2 class="h6 text-uppercase fw-bold">Hubungi Kami</h2>
				<p class="text-white-50 mb-1">Email: info@arcticstore.id</p>
				<p class="text-white-50 mb-0">Senin–Jumat, 09.00–17.00 WIB</p>
			</div>
		</div>

		<hr class="border-secondary my-4">

		<div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
			<small class="text-white-50">&copy; {{ date('Y') }} ArcticStore. Hak cipta dilindungi.</small>
			<a href="#top" class="link-light link-opacity-75-hover text-decoration-none">Kembali ke atas</a>
		</div>
	</div>
</footer>
