document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('layananForm');
    const btnSubmit = document.getElementById('btnSubmit');

    if (form && btnSubmit) {
        form.addEventListener('submit', (e) => {
            const requiredInputs = form.querySelectorAll('[required]');
            let isValid = true;

            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
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

            btnSubmit.classList.add('loading');
            btnSubmit.querySelector('.btn-loader').style.display = 'flex';
        });
    }

    const inputs = document.querySelectorAll('.input-modern');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.classList.add('focused');
        });
        input.addEventListener('blur', () => {
            input.parentElement.classList.remove('focused');
        });
    });

    console.log("Edit Layanan loaded");
});