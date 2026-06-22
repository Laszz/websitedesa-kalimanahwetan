document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alert after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Confirm delete with custom message
    const hapusForms = document.querySelectorAll('.form-hapus');
    hapusForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const judul = this.closest('tr').querySelector('.agenda-judul').childNodes[0].textContent.trim();
            if (!confirm(`Yakin hapus agenda "${judul}"?`)) {
                e.preventDefault();
            }
        });
    });
});