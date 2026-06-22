document.addEventListener("DOMContentLoaded", function () {
    console.log("Edit profile page loaded");

    const card = document.querySelector(".profile-card");
    if (card) {
        card.style.opacity = "0";
        card.style.transform = "translateY(20px)";
        card.style.transition = "opacity 0.5s ease, transform 0.5s ease";
        
        requestAnimationFrame(() => {
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        });
    }

    document.querySelectorAll(".profile-form input, .profile-form select, .profile-form textarea")
        .forEach(function (el) {
            el.addEventListener("focus", function () {
                this.style.backgroundColor = "#f8f9fa";
            });
            el.addEventListener("blur", function () {
                this.style.backgroundColor = "";
            });
        });

    const nikInput = document.getElementById("nik");
    const kkInput = document.getElementById("kk");

    [nikInput, kkInput].forEach(input => {
        if (!input) return;
        input.addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, "");
        });
    });

    const umurInput = document.getElementById("umur");
    if (umurInput) {
        umurInput.addEventListener("input", function () {
            if (this.value < 0) this.value = 0;
        });
    }

    const fotoInput = document.getElementById("foto");
    const fotoPreviewContainer = document.getElementById("fotoPreviewContainer");
    const fotoPreview = document.getElementById("fotoPreview");

    if (fotoInput) {
        fotoInput.addEventListener("change", function (e) {
            const file = e.target.files[0];
            
            if (file && file.type.startsWith("image/")) {
                if (file.size > 2 * 1024 * 1024) {
                    alert("Ukuran foto maksimal 2MB!");
                    fotoInput.value = "";
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function (event) {
                    fotoPreview.src = event.target.result;
                    fotoPreviewContainer.style.display = "block";
                    
                    fotoPreview.style.opacity = "0";
                    fotoPreview.style.transition = "opacity 0.3s ease";
                    
                    requestAnimationFrame(() => {
                        fotoPreview.style.opacity = "1";
                    });
                };
                reader.readAsDataURL(file);
            } else {
                fotoPreviewContainer.style.display = "none";
            }
        });
    }
});