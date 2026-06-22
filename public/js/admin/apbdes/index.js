// ============================================
// APBDES - INDEX (DASHBOARD)
// ============================================

(function() {
    'use strict';

    const indexWrapper = document.querySelector('.apbdes-index');
    if (!indexWrapper) return;

    // Auto dismiss alerts after 5 seconds
    const alerts = indexWrapper.querySelectorAll('.apbdes-alert');
    alerts.forEach(alert => {
        const closeBtn = alert.querySelector('.alert-close');
        
        // Close button click
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                dismissAlert(alert);
            });
        }
        
        // Auto dismiss
        setTimeout(() => {
            dismissAlert(alert);
        }, 5000);
    });

    function dismissAlert(alert) {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        alert.style.transition = 'all 0.3s ease';
        setTimeout(() => alert.remove(), 300);
    }

    // Animate progress bar on load
    const progressBar = indexWrapper.querySelector('.progress-bar[data-progress]');
    if (progressBar) {
        const progressFill = progressBar.querySelector('.progress-fill');
        const targetWidth = progressBar.dataset.progress + '%';
        
        // Start from 0, animate to target
        requestAnimationFrame(() => {
            progressFill.style.width = targetWidth;
        });
    }

    // Animate stats counter
    const statValues = indexWrapper.querySelectorAll('[data-counter]');
    statValues.forEach(stat => {
        const text = stat.textContent.trim();
        
        // Skip non-numeric (like year "2024")
        if (!text.includes('Rp')) return;
        
        // Parse: "Rp 1.234.567" or "Rp -1.234.567"
        const isNegative = text.includes('-');
        const cleanText = text.replace('-', '').replace('Rp ', '');
        const targetValue = parseInt(cleanText.replace(/\./g, ''), 10);
        
        if (isNaN(targetValue)) return;
        
        const prefix = isNegative ? '-Rp ' : 'Rp ';
        const duration = 1000;
        const steps = 30;
        const increment = targetValue / steps;
        const interval = duration / steps;
        
        let current = 0;
        const timer = setInterval(() => {
            current += increment;
            if (current >= targetValue) {
                current = targetValue;
                clearInterval(timer);
            }
            stat.textContent = prefix + new Intl.NumberFormat('id-ID').format(Math.floor(current));
        }, interval);
    });

    // Quick card hover effect enhancement
    const quickCards = indexWrapper.querySelectorAll('.quick-card');
    quickCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-6px) scale(1.02)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });

    console.log('APBDES Dashboard loaded');
})();