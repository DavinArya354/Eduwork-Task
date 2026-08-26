const registerForm = document.getElementById("register-form");
const loginForm = document.getElementById("login-form");

const authSection = document.getElementById("auth-section");
const profileSection = document.getElementById("profile-section");

const profilePhoto = document.getElementById("profile-photo");
const profileUsername = document.getElementById("profile-username");
const profileEmail = document.getElementById("profile-email");

const navProfilePhoto = document.getElementById("nav-profile-photo");
const navUsername = document.getElementById("nav-username");

const logoutBtn = document.getElementById("logout-btn");
const changePhoto = document.getElementById("change-photo");


// ============================
// DEFAULT PROFILE PHOTO
// ============================

const defaultPhoto =
    "data:image/svg+xml;charset=UTF-8," +
    encodeURIComponent(`
        <svg
            xmlns="http://www.w3.org/2000/svg"
            width="150"
            height="150"
            viewBox="0 0 150 150">

            <rect
                width="150"
                height="150"
                fill="#e9ecef"/>

            <circle
                cx="75"
                cy="55"
                r="25"
                fill="#adb5bd"/>

            <path
                d="M35 125
                   C35 95 50 80 75 80
                   C100 80 115 95 115 125"
                fill="#adb5bd"/>

        </svg>
    `);


// ============================
// LOAD USER
// ============================

function getUser() {
    return JSON.parse(localStorage.getItem("user"));
}


// ============================
// SAVE USER
// ============================

function saveUser(user) {
    localStorage.setItem("user", JSON.stringify(user));
}


// ============================
// REGISTER
// ============================

registerForm.addEventListener("submit", function (event) {

    event.preventDefault();

    const username =
        document.getElementById("register-username").value;

    const email =
        document.getElementById("register-email").value;

    const password =
        document.getElementById("register-password").value;

    const photoInput =
        document.getElementById("register-photo");


    if (photoInput.files.length > 0) {

        const reader = new FileReader();

        reader.onload = function () {

            createUser(
                username,
                email,
                password,
                reader.result
            );

        };

        reader.readAsDataURL(photoInput.files[0]);

    } else {

        createUser(
            username,
            email,
            password,
            defaultPhoto
        );

    }

});


// ============================
// CREATE USER
// ============================

function createUser(username, email, password, photo) {

    const user = {
        username: username,
        email: email,
        password: password,
        photo: photo
    };

    saveUser(user);

    localStorage.setItem("loggedIn", "true");

    alert("Account berhasil dibuat!");

    registerForm.reset();

    updateUserUI();
}


// ============================
// LOGIN
// ============================

loginForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const email =
        document.getElementById("login-email").value;

    const password =
        document.getElementById("login-password").value;

    const user = getUser();

    if (!user) {
        alert("Account belum dibuat.");
        return;
    }


    if (
        email === user.email &&
        password === user.password
    ) {

        localStorage.setItem("loggedIn", "true");
        alert("Login berhasil!");

        loginForm.reset();
        updateUserUI();

    } else {
        alert("Email atau password salah.");
    }

});


// ============================
// LOGOUT
// ============================

logoutBtn.addEventListener("click", function () {
    localStorage.setItem("loggedIn", "false");
    updateUserUI();
});


// ============================
// CHANGE PHOTO
// ============================

changePhoto.addEventListener("change", function () {
    const file = this.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = function () {

        const user = getUser();

        if (!user) return;

        user.photo = reader.result;

        saveUser(user);
        updateUserUI();

    };

    reader.readAsDataURL(file);

});


// ============================
// UPDATE UI
// ============================

function updateUserUI() {
    const user = getUser();

    const loggedIn =
        localStorage.getItem("loggedIn") === "true";


    if (user && loggedIn) {
        // Hide login/register
        authSection.classList.add("d-none");

        // Show profile
        profileSection.classList.remove("d-none");

        // Profile information
        profileUsername.textContent = user.username;

        profileEmail.textContent = user.email;

        // Profile photo
        profilePhoto.src = user.photo || defaultPhoto;

        navProfilePhoto.src = user.photo || defaultPhoto;

        navUsername.textContent = user.username;

    } else {

        // Show login/register
        authSection.classList.remove("d-none");

        // Hide profile
        profileSection.classList.add("d-none");

        // Navbar
        navProfilePhoto.src =
            defaultPhoto;

        navUsername.textContent =
            "Login";

    }

}


// ============================
// INITIALIZE
// ============================

updateUserUI();

let cart = JSON.parse(localStorage.getItem("cart")) || [];
updateCartBadge(cart);
