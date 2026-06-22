document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('formAjukan');
    const btnSubmit = document.getElementById('btnSubmit');

    // File upload preview & drag-drop
    const fileInputs = document.querySelectorAll('.file-input');

    fileInputs.forEach(input => {
        const wrapper = input.closest('.file-upload-wrapper');
        const preview = wrapper.querySelector('.file-preview');
        const previewId = preview.id;
        const reqId = input.id.replace('file_', '');

        // Drag & drop effects
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

        // File selected
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
                
                // Update label text
                const label = wrapper.querySelector('.file-label');
                label.querySelector('.file-main').textContent = 'File terpilih';
                label.querySelector('.file-sub').textContent = file.name;
            }
        });
    });

    // Clear file function
    window.clearFile = function(previewId, inputId) {
        const preview = document.getElementById(previewId);
        const input = document.getElementById(inputId);
        const wrapper = input.closest('.file-upload-wrapper');
        
        input.value = '';
        preview.classList.remove('active');
        preview.innerHTML = '';
        
        // Reset label
        const label = wrapper.querySelector('.file-label');
        label.querySelector('.file-main').textContent = 'Klik untuk upload file';
        label.querySelector('.file-sub').textContent = 'atau drag & drop disini';
    };

    // Form submit loading
    if (form && btnSubmit) {
        form.addEventListener('submit', (e) => {
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

            // Show loading
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

    console.log("✨ Form Ajukan loaded with modern features");
});