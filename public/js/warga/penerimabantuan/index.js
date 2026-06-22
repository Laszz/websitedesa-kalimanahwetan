/**
 * WARGA PENERIMA BANTUAN — INDEX JS
 * Animasi counter, responsive table, dan interaksi
 */

document.addEventListener('DOMContentLoaded', function() {
    initCounterAnimation();
    initResponsiveTable();
});

/**
 * Animasi counter dengan efek counting up
 */
function initCounterAnimation() {
    const counters = document.querySelectorAll('.wpb-counter-value[data-target]');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target')) || 0;
        const duration = 1000; // ms
        const startTime = performance.now();
        
        function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            // Easing: easeOutQuart
            const easeProgress = 1 - Math.pow(1 - progress, 4);
            const current = Math.round(easeProgress * target);
            
            counter.textContent = current;
            
            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        }
        
        // Observer untuk trigger animasi saat terlihat
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    requestAnimationFrame(updateCounter);
                    observer.unobserve(counter);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(counter);
    });
}

/**
 * Responsive table: tambah data-label untuk mobile view
 */
function initResponsiveTable() {
    const table = document.querySelector('.wpb-table');
    if (!table) return;
    
    const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        cells.forEach((cell, index) => {
            if (headers[index]) {
                cell.setAttribute('data-label', headers[index]);
            }
        });
    });
}