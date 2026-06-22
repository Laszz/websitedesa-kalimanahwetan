document.addEventListener("DOMContentLoaded", () => {
    console.log("Login page loaded");

    // ===== AUTO CLOSE ALERT (pindah dari blade) =====
    setTimeout(() => {
        document.querySelectorAll('[id^="alert-"]').forEach(el => el.remove());
    }, 5000);

    // ===== TOGGLE PASSWORD =====
    const passwordField = document.querySelector("#password");
    const toggleBtn = document.querySelector("#togglePassword");

    if (passwordField && toggleBtn) {
        toggleBtn.addEventListener("click", () => {
            const icon = toggleBtn.querySelector("i");
            const isPassword = passwordField.type === "password";

            passwordField.type = isPassword ? "text" : "password";
            icon.className = isPassword ? "fa-solid fa-eye-slash" : "fa-solid fa-eye";
        });
    }

    // ===== LOADING STATE =====
    const form = document.querySelector("#loginForm");
    const btnSubmit = document.querySelector("#btnSubmit");
    const btnText = btnSubmit?.querySelector(".btn-text");
    const btnLoader = btnSubmit?.querySelector(".btn-loader");

    if (form && btnSubmit) {
        form.addEventListener("submit", (e) => {
            const email = document.querySelector("#email").value.trim();
            const password = document.querySelector("#password").value.trim();

            if (!email || !password) {
                e.preventDefault();
                return;
            }

            btnSubmit.disabled = true;
            if (btnText) btnText.style.opacity = "0";
            if (btnLoader) btnLoader.style.display = "flex";
        });
    }

    // ===== CUSTOM VALIDATION =====
    const emailInput = document.querySelector("#email");
    const passInput = document.querySelector("#password");

    if (emailInput) {
        emailInput.oninvalid = (e) => e.target.setCustomValidity("Email wajib diisi");
        emailInput.oninput = (e) => e.target.setCustomValidity("");
    }

    if (passInput) {
        passInput.oninvalid = (e) => e.target.setCustomValidity("Password wajib diisi");
        passInput.oninput = (e) => e.target.setCustomValidity("");
    }
});