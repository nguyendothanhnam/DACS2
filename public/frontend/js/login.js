document.addEventListener("DOMContentLoaded", () => {
    const loginSection = document.getElementById("loginSection");
    const showLoginBtn = document.getElementById("showLogin");

    // Load the login HTML into the section
    fetch("layout-login.blade.php")
        .then((response) => response.text())
        .then((html) => {
            loginSection.innerHTML = html;
        })
        .catch((error) => {
            console.error("Lỗi khi tải giao diện đăng nhập:", error);
        });

    // Show the login modal when the button is clicked
    showLoginBtn.addEventListener("click", () => {
        const loginModal = new bootstrap.Modal(document.getElementById("loginModal"));
        loginModal.show();
    });
});
