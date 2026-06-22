document.addEventListener('DOMContentLoaded', function() {
    
    // Status change warning
    const statusSelect = document.getElementById('status-select');
    if (statusSelect) {
        const originalStatus = statusSelect.value;
        
        statusSelect.addEventListener('change', function() {
            if (this.value === 'dicabut' && originalStatus !== 'dicabut') {
                if (!confirm('Status "Dicabut" akan menonaktifkan bantuan ini. Lanjutkan?')) {
                    this.value = originalStatus;
                }
            }
        });
    }

    // Auto-dismiss alerts
    const alerts = document.querySelectorAll('.pb-alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const closeBtn = alert.querySelector('.btn-close');
            if (closeBtn) closeBtn.click();
        }, 5000);
    });

    console.log('Penerima Bantuan Edit JS loaded');
});