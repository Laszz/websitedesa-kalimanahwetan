document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ Admin - Edit Aduan loaded");

    // === Auto Preview Gambar ===
    const inputFile = document.querySelector('input[name="gambar"]');
    if (inputFile) {
        inputFile.addEventListener("change", (e) => {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = (event) => {
                let preview = document.querySelector(".preview-img");

                if (!preview) {
                    preview = document.createElement("img");
                    preview.classList.add("preview-img");
                    const wrapper = document.createElement("div");
                    wrapper.classList.add("preview-wrapper");
                    wrapper.appendChild(preview);
                    inputFile.parentNode.appendChild(wrapper);
                }

                preview.src = event.target.result;
            };
            reader.readAsDataURL(file);
        });
    }

    // === Warna Prioritas Dinamis ===
    const selectPrioritas = document.querySelector('select[name="prioritas"]');
    if (selectPrioritas) {
        const colors = {
            normal: "#f3f4f6",
            penting: "#fef9c3",
            darurat: "#fee2e2",
        };

        const updateColor = () => {
            selectPrioritas.style.background = colors[selectPrioritas.value] || "#fff";
        };

        updateColor();
        selectPrioritas.addEventListener("change", updateColor);
    }

    // === Validasi Nomor WA ===
    const waInput = document.querySelector('input[name="nomor_wa"]');
    if (waInput) {
        waInput.addEventListener("input", () => {
            const regex = /^(\+62|62|0)[0-9]{9,13}$/;
            const val = waInput.value.trim();

            if (val === "") {
                waInput.style.borderColor = "#d1d5db";
            } else if (!regex.test(val)) {
                waInput.style.borderColor = "#ef4444";
            } else {
                waInput.style.borderColor = "#22c55e";
            }
        });
    }
});