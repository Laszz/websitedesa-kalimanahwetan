document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================================
    // Counter Animation
    // ==========================================
    const counters = document.querySelectorAll('.pb-counter-value');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target')) || 0;
        
        if (target === 0) {
            counter.textContent = '0';
            return;
        }
        
        const duration = 1200;
        const frameRate = 60;
        const totalFrames = Math.round(duration / (1000 / frameRate));
        const step = target / totalFrames;
        let current = 0;
        let frame = 0;
        
        const updateCounter = () => {
            frame++;
            current += step;
            
            const progress = frame / totalFrames;
            const easedProgress = 1 - Math.pow(1 - progress, 3);
            const displayValue = Math.min(Math.round(target * easedProgress), target);
            
            counter.textContent = displayValue;
            
            if (frame < totalFrames) {
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        
        setTimeout(() => {
            requestAnimationFrame(updateCounter);
        }, 200);
    });

    // ==========================================
    // Delete Confirmation
    // ==========================================
    const deleteForms = document.querySelectorAll('.pb-delete-form');
    
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const confirmed = confirm('Yakin ingin menghapus data penerima bantuan ini?');
            if (!confirmed) {
                e.preventDefault();
            }
        });
    });

    // ==========================================
    // Auto-dismiss Alerts
    // ==========================================
    const alerts = document.querySelectorAll('.pb-alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            const closeBtn = alert.querySelector('.btn-close');
            if (closeBtn) {
                closeBtn.click();
            }
        }, 5000);
    });

    // ==========================================
    // Smooth scroll to alert if exists
    // ==========================================
    const firstAlert = document.querySelector('.pb-alert');
    if (firstAlert) {
        firstAlert.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // ==========================================
    // Filter Form - Enter key support
    // ==========================================
    const filterForm = document.querySelector('.pb-filter-form');
    const keywordInput = document.querySelector('input[name="keyword"]');
    
    if (keywordInput && filterForm) {
        keywordInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                filterForm.submit();
            }
        });
    }

    console.log('Penerima Bantuan Index JS loaded');
});