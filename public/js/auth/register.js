document.addEventListener("DOMContentLoaded", () => {

    const tanggalLahirInput = document.getElementById("tanggal_lahir");
    const umurDisplay = document.getElementById("umur_display");
    const umurHidden = document.getElementById("umur");
    const nikInput = document.getElementById("nik");
    const kkInput = document.getElementById("kk");
    const fotoInput = document.getElementById("foto");
    const fotoPreview = document.getElementById("fotoPreview");
    const form = document.getElementById("registerForm");
    const btnSubmit = document.getElementById("btnSubmit");
    const btnText = btnSubmit.querySelector(".btn-text");
    const btnLoader = btnSubmit.querySelector(".btn-loader");

    // ===== HITUNG UMUR OTOMATIS =====
    function hitungUmur() {
        const dob = new Date(tanggalLahirInput.value);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        if (!isNaN(age) && age >= 0) {
            umurDisplay.value = age + " tahun";
            umurHidden.value = age;
        } else {
            umurDisplay.value = "";
            umurHidden.value = "";
        }
    }

    tanggalLahirInput.addEventListener("input", hitungUmur);
    if (tanggalLahirInput.value) hitungUmur();

    // ===== VALIDASI NIK & KK (HANYA ANGKA, 16 DIGIT) =====
    function setupNumericValidation(input, hintId) {
        input.addEventListener("input", (e) => {
            input.value = input.value.replace(/\D/g, "");
            const len = input.value.length;
            const hint = document.getElementById(hintId);

            if (hint) {
                if (len === 16) {
                    hint.textContent = "✓ Valid";
                    hint.className = "input-hint valid";
                } else if (len > 0) {
                    hint.textContent = `${len}/16 digit`;
                    hint.className = "input-hint invalid";
                } else {
                    hint.textContent = "Masukkan 16 digit angka";
                    hint.className = "input-hint";
                }
            }
        });
    }

    setupNumericValidation(nikInput, "nikHint");
    setupNumericValidation(kkInput, "kkHint");

    // ===== PREVIEW FOTO =====
    fotoInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert("Ukuran foto maksimal 2MB");
            fotoInput.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = (event) => {
            fotoPreview.innerHTML = `<img src="${event.target.result}" alt="Preview">`;
        };
        reader.readAsDataURL(file);
    });

    // ===== TOGGLE PASSWORD VISIBILITY =====
    document.querySelectorAll(".toggle-password").forEach(btn => {
        btn.addEventListener("click", () => {
            const targetId = btn.dataset.target;
            const input = document.getElementById(targetId);
            const icon = btn.querySelector("i");
            const isPassword = input.type === "password";

            input.type = isPassword ? "text" : "password";
            icon.className = isPassword ? "fa-solid fa-eye-slash" : "fa-solid fa-eye";
        });
    });

    // ===== LOADING STATE SAAT SUBMIT =====
    form.addEventListener("submit", (e) => {
        if (nikInput.value.length !== 16) {
            e.preventDefault();
            nikInput.focus();
            nikInput.style.borderColor = "#ef4444";
            setTimeout(() => nikInput.style.borderColor = "", 2000);
            return;
        }

        if (kkInput.value.length !== 16) {
            e.preventDefault();
            kkInput.focus();
            kkInput.style.borderColor = "#ef4444";
            setTimeout(() => kkInput.style.borderColor = "", 2000);
            return;
        }

        btnSubmit.disabled = true;
        btnText.style.opacity = "0";
        btnLoader.style.display = "flex";
    });
});