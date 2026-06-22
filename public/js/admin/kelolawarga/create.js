document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('wargaForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const fotoInput = document.getElementById('fotoInput');
    const fotoPreview = document.getElementById('fotoPreview');
    const alertCloses = document.querySelectorAll('.alert-close');

    // Close alert
    alertCloses.forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.warga-alert').style.display = 'none';
        });
    });

    // Auto-hide alert after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.warga-alert').forEach(alert => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // File upload preview & drag-drop
    if (fotoInput) {
        const fileWrapper = fotoInput.closest('.file-upload-wrapper');
        const fileLabel = fileWrapper.querySelector('.file-label');

        ['dragenter', 'dragover'].forEach(eventName => {
            fotoInput.addEventListener(eventName, (e) => {
                e.preventDefault();
                fileLabel.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fotoInput.addEventListener(eventName, (e) => {
                e.preventDefault();
                fileLabel.classList.remove('dragover');
            });
        });

        fotoInput.addEventListener('change', () => {
            if (fotoInput.files.length > 0) {
                const file = fotoInput.files[0];
                const fileSize = (file.size / 1024 / 1024).toFixed(2);

                fotoPreview.innerHTML = `
                    <span class="file-preview-icon"><i class="fa-solid fa-image"></i></span>
                    <span class="file-preview-name">${file.name} (${fileSize} MB)</span>
                    <button type="button" class="file-preview-remove" onclick="clearFoto()" title="Hapus"><i class="fa-solid fa-xmark"></i></button>
                `;
                fotoPreview.classList.add('active');

                const fileMain = fileLabel.querySelector('.file-main');
                const fileSub = fileLabel.querySelector('.file-sub');
                if (fileMain) fileMain.textContent = 'Foto dipilih';
                if (fileSub) fileSub.textContent = file.name;
            }
        });
    }

    // Clear foto function
    window.clearFoto = function() {
        fotoInput.value = '';
        fotoPreview.classList.remove('active');
        fotoPreview.innerHTML = '';

        const fileLabel = fotoInput.closest('.file-upload-wrapper').querySelector('.file-label');
        const fileMain = fileLabel.querySelector('.file-main');
        const fileSub = fileLabel.querySelector('.file-sub');
        if (fileMain) fileMain.textContent = 'Klik untuk upload foto';
        if (fileSub) fileSub.textContent = 'atau drag & drop disini';
    };

    // Form submit loading
    if (form && btnSubmit) {
        form.addEventListener('submit', (e) => {
            const requiredInputs = form.querySelectorAll('[required]');
            let isValid = true;

            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = '#ef4444';
                    input.style.animation = 'shake 0.4s ease-out';
                    setTimeout(() => {
                        input.style.borderColor = '';
                        input.style.animation = '';
                    }, 2000);
                }
            });

            if (!isValid) {
                e.preventDefault();
                return;
            }

            btnSubmit.classList.add('loading');
            btnSubmit.querySelector('.btn-loader').style.display = 'flex';
        });
    }

    // Input focus effects
    const inputs = document.querySelectorAll('.input-modern');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.classList.add('focused');
        });
        input.addEventListener('blur', () => {
            input.parentElement.classList.remove('focused');
        });
    });

    console.log("✨ Create Warga loaded");
});