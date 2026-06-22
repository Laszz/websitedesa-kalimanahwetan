document.addEventListener('DOMContentLoaded', function() {
    
    // Auto-dismiss alerts
    const alerts = document.querySelectorAll('.jb-alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const closeBtn = alert.querySelector('.btn-close');
            if (closeBtn) closeBtn.click();
        }, 5000);
    });

    console.log('Jenis Bantuan Create JS loaded');
});