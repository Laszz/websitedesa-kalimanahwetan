document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('formAjukan');
    const btnSubmit = document.getElementById('btnSubmit');

    // ===== ANTI DOUBLE SUBMIT =====
    if (form && btnSubmit) {
        form.addEventListener('submit', (e) => {
            // Cegah submit ganda
            if (btnSubmit.disabled) {
                e.preventDefault();
                return false;
            }

            // Simple validation
            const requiredInputs = form.querySelectorAll('[required]');
            let isValid = true;

            requiredInputs.forEach(input => {
                if (!input.value) {
                    isValid = false;
                    input.style.borderColor = 'var(--danger)';
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

            // Disable tombol + tampilkan loading
            btnSubmit.disabled = true;
            btnSubmit.classList.add('loading');
            btnSubmit.querySelector('.btn-loader').style.display = 'flex';
            btnSubmit.querySelector('.btn-text').style.opacity = '0.5';
        });
    }

    // Re-enable tombol saat halaman di-load ulang (error validasi)
    window.addEventListener("pageshow", () => {
        if (btnSubmit) {
            btnSubmit.disabled = false;
            btnSubmit.classList.remove('loading');
            btnSubmit.querySelector('.btn-loader').style.display = 'none';
            btnSubmit.querySelector('.btn-text').style.opacity = '1';
        }
    });

    // File upload preview & drag-drop
    const fileInputs = document.querySelectorAll('.file-input');

    fileInputs.forEach(input => {
        const wrapper = input.closest('.file-upload-wrapper');
        const preview = wrapper.querySelector('.file-preview');
        const previewId = preview.id;
        const reqId = input.id.replace('file_', '');

        ['dragenter', 'dragover'].forEach(eventName => {
            input.addEventListener(eventName, (e) => {
                e.preventDefault();
                wrapper.querySelector('.file-label').style.borderColor = 'var(--primary)';
                wrapper.querySelector('.file-label').style.background = 'var(--primary-light)';
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            input.addEventListener(eventName, (e) => {
                e.preventDefault();
                wrapper.querySelector('.file-label').style.borderColor = '';
                wrapper.querySelector('.file-label').style.background = '';
            });
        });

        input.addEventListener('change', () => {
            if (input.files.length > 0) {
                const file = input.files[0];
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                
                preview.innerHTML = `
                    <span class="file-preview-icon">📄</span>
                    <span class="file-preview-name">${file.name} (${fileSize} MB)</span>
                    <button type="button" class="file-preview-remove" onclick="clearFile('${previewId}', '${input.id}')">×</button>
                `;
                preview.classList.add('active');
                
                const label = wrapper.querySelector('.file-label');
                label.querySelector('.file-main').textContent = 'File terpilih';
                label.querySelector('.file-sub').textContent = file.name;
            }
        });
    });

    window.clearFile = function(previewId, inputId) {
        const preview = document.getElementById(previewId);
        const input = document.getElementById(inputId);
        const wrapper = input.closest('.file-upload-wrapper');
        
        input.value = '';
        preview.classList.remove('active');
        preview.innerHTML = '';
        
        const label = wrapper.querySelector('.file-label');
        label.querySelector('.file-main').textContent = 'Klik untuk upload file';
        label.querySelector('.file-sub').textContent = 'atau drag & drop disini';
    };

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

    console.log("✨ Form Ajukan loaded with anti-double-submit");
});