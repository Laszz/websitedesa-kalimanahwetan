document.addEventListener('DOMContentLoaded', function() {
    // Animasi fade-in card saat halaman load
    const card = document.querySelector('.card');
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
    }, 100);

    // Validasi form sebelum submit
    const form = document.getElementById('resetForm');
    const emailInput = document.getElementById('email');
    const errorElement = document.querySelector('.error');

    if (form) {
        form.addEventListener('submit', function(e) {
            const email = emailInput.value.trim();
            
            // Reset error
            if (errorElement) {
                errorElement.textContent = '';
            }
            emailInput.style.borderColor = '#d1d5db';

            // Cek email kosong
            if (!email) {
                e.preventDefault();
                showError('Email wajib diisi.');
                return;
            }

            // Cek format email
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                e.preventDefault();
                showError('Format email tidak valid.');
                return;
            }

            // Loading state
            const btn = form.querySelector('.btn');
            btn.textContent = 'Mengirim...';
            btn.disabled = true;
            btn.style.opacity = '0.7';
        });
    }

    function showError(message) {
        if (errorElement) {
            errorElement.textContent = message;
        }
        emailInput.style.borderColor = '#ef4444';
        emailInput.focus();
    }

    // Hapus error saat user mulai ngetik
    if (emailInput) {
        emailInput.addEventListener('input', function() {
            if (errorElement) {
                errorElement.textContent = '';
            }
            this.style.borderColor = '#d1d5db';
        });
    }
});