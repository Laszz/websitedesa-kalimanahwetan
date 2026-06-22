document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('resetForm');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');

    // Animasi fade-in card
    const card = document.querySelector('.card');
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
    }, 100);

    if (form) {
        form.addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            let hasError = false;

            // Reset error
            clearErrors();

            // Validasi password kosong
            if (!password) {
                e.preventDefault();
                showError(passwordInput, 'Password wajib diisi.');
                hasError = true;
            }
            // Validasi panjang password
            else if (password.length < 8) {
                e.preventDefault();
                showError(passwordInput, 'Password minimal 8 karakter.');
                hasError = true;
            }

            // Validasi konfirmasi password
            if (!confirm) {
                e.preventDefault();
                showError(confirmInput, 'Konfirmasi password wajib diisi.');
                hasError = true;
            }
            else if (password !== confirm) {
                e.preventDefault();
                showError(confirmInput, 'Password tidak cocok.');
                hasError = true;
            }

            // Loading state
            if (!hasError) {
                const btn = form.querySelector('.btn');
                btn.textContent = 'Memproses...';
                btn.disabled = true;
            }
        });
    }

    function showError(input, message) {
        // Cari atau buat elemen error
        let errorEl = input.parentNode.querySelector('.error');
        if (!errorEl) {
            errorEl = document.createElement('span');
            errorEl.className = 'error';
            input.parentNode.appendChild(errorEl);
        }
        errorEl.textContent = message;
        input.style.borderColor = '#ef4444';
        input.classList.add('shake');
        
        setTimeout(() => input.classList.remove('shake'), 300);
    }

    function clearErrors() {
        document.querySelectorAll('.error').forEach(el => el.textContent = '');
        document.querySelectorAll('input').forEach(input => {
            input.style.borderColor = '#d1d5db';
        });
    }

    // Hapus error saat user ngetik
    [passwordInput, confirmInput].forEach(input => {
        if (input) {
            input.addEventListener('input', function() {
                const errorEl = this.parentNode.querySelector('.error');
                if (errorEl) errorEl.textContent = '';
                this.style.borderColor = '#d1d5db';
            });
        }
    });
});