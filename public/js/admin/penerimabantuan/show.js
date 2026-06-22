document.addEventListener('DOMContentLoaded', function() {
    
    // Alert close button
    const alertCloseBtns = document.querySelectorAll('.alert-close');
    alertCloseBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const alert = this.closest('.pb-alert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                alert.style.transition = 'all 0.3s ease';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            }
        });
    });

    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.pb-alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            alert.style.transition = 'all 0.3s ease';
            setTimeout(function() {
                alert.remove();
            }, 300);
        }, 5000);
    });

    console.log('Penerima Bantuan Show JS loaded');
});