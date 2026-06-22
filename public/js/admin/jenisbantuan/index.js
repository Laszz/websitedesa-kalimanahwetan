document.addEventListener('DOMContentLoaded', function() {
    
    // Delete confirmation
    const deleteForms = document.querySelectorAll('.jb-delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Yakin ingin menghapus jenis bantuan ini?')) {
                e.preventDefault();
            }
        });
    });

    // Auto-dismiss alerts
    const alerts = document.querySelectorAll('.jb-alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const closeBtn = alert.querySelector('.btn-close');
            if (closeBtn) closeBtn.click();
        }, 5000);
    });

    console.log('Jenis Bantuan Index JS loaded');
});