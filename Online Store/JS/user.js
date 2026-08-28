<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Account</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- ================= NAVBAR ================= -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-bag-fill"></i>
                ArcticStore
            </a>

            <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="shop.html">
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Produk
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link position-relative" href="cart.html">
                            <i class="bi bi-cart3 fs-5"></i>
                            <span
                                class="top-0 start-100 translate-middle cart-badge"
                                id="cart-count">
                                0
                            </span>
                        </a>
                    </li>
                    <!-- USER -->
                    <li class="nav-item user-nav-item">
                        <a class="nav-link user-nav-link" href="user.html">
                            <img id="nav-profile-photo"
                                src=""
                                alt="Profile"
                                class="nav-profile-photo">
                            <span id="nav-username">Login</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- USER PAGE -->
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="user-card">

                    <div class="text-center mb-4">
                        <div class="profile-photo-wrapper">
                            <img
                                id="profile-photo"
                                src=""
                                alt="Profile Photo"
                                class="profile-photo">
                        </div>

                        <h2 id="account-title" class="mt-3">
                            My Account
                        </h2>
                    </div>

                    <!-- AUTH SECTION -->
                    <div id="auth-section">

                        <!-- SIGN IN -->
                        <div id="login-tab" class="auth-tab">
                            <h2 class="auth-title">
                                Sign In
                            </h2>

                            <p class="auth-subtitle">
                                Welcome back! Please sign in to your account.
                            </p>

                            <form id="login-form">
                                <div class="mb-3">
                                    <label for="login-email" class="form-label">
                                        Email
                                    </label>

                                    <input
                                        type="email"
                                        id="login-email"
                                        class="form-control"
                                        placeholder="Enter your email"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="login-password" class="form-label">
                                        Password
                                    </label>

                                    <input
                                        type="password"
                                        id="login-password"
                                        class="form-control"
                                        placeholder="Enter your password"
                                        required>
                                </div>

                                <button
                                    type="submit"
                                    class="signIn-btn">
                                    Sign In
                                </button>
                            </form>

                            <!-- SWITCH TO REGISTER -->
                            <div class="auth-switch">
                                <span>
                                    Don't have an account?
                                </span>

                                <button
                                    type="button"
                                    id="show-register"
                                    class="auth-switch-btn">
                                    Create Account
                                </button>
                            </div>
                        </div>


                        <!-- CREATE ACCOUNT -->
                        <div id="register-tab" class="auth-tab d-none">

                            <h2 class="auth-title">
                                Create Account
                            </h2>

                            <p class="auth-subtitle">
                                Create your account to get started.
                            </p>

                            <form id="register-form">
                                <div class="mb-3">
                                    <label for="register-username" class="form-label">
                                        Username
                                    </label>

                                    <input
                                        type="text"
                                        id="register-username"
                                        class="form-control"
                                        placeholder="Enter your username"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="register-email" class="form-label">
                                        Email
                                    </label>

                                    <input
                                        type="email"
                                        id="register-email"
                                        class="form-control"
                                        placeholder="Enter your email"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="register-password" class="form-label">
                                        Password
                                    </label>

                                    <input
                                        type="password"
                                        id="register-password"
                                        class="form-control"
                                        placeholder="Create a password"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="register-photo" class="form-label">
                                        Profile Photo
                                    </label>

                                    <input
                                        type="file"
                                        id="register-photo"
                                        class="form-control"
                                        accept="image/*">
                                </div>

                                <button
                                    type="submit"
                                    class="createAcc-btn">
                                    Create Account
                                </button>
                            </form>


                            <!-- SWITCH TO LOGIN -->
                            <div class="auth-switch">
                                <span>
                                    Already have an account?
                                </span>

                                <button
                                    type="button"
                                    id="show-login"
                                    class="auth-switch-btn">
                                    Sign In
                                </button>
                            </div>

                        </div>

                    </div>


                    <!-- PROFILE -->
                    <div id="profile-section" class="d-none">
                        <div class="text-center">
                            <h3 id="profile-username">
                                Username
                            </h3>

                            <p
                                id="profile-email"
                                class="text-muted">
                                email@example.com
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Change Profile Photo
                            </label>

                            <input
                                type="file"
                                id="change-photo"
                                class="form-control"
                                accept="image/*">
                        </div>

                        <button
                            id="logout-btn"
                            class="btn btn-danger w-100">
                            Logout
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </main>
 
    <script src="js/utils.js"></script>
    <script src="js/user.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>
</body>
</html>
