/**
 * PUBLIC PENERIMA BANTUAN — SHOW JS
 */

document.addEventListener('DOMContentLoaded', function() {
    initStatBars();
    initResponsiveTable();
});

/**
 * Animasi progress bar desil
 * Width diambil dari data attribute, di-set via JS
 */
function initStatBars() {
    const bars = document.querySelectorAll('.ppb-stat-bar');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bar = entry.target;
                const targetWidth = bar.getAttribute('data-width');
                
                if (targetWidth) {
                    // Reset ke 0
                    bar.style.width = '0%';
                    
                    // Trigger reflow
                    void bar.offsetWidth;
                    
                    // Animasi ke width target
                    setTimeout(() => {
                        bar.style.width = targetWidth + '%';
                    }, 100);
                }
                
                observer.unobserve(bar);
            }
        });
    }, { threshold: 0.5 });
    
    bars.forEach(bar => observer.observe(bar));
}

/**
 * Responsive table labels
 */
function initResponsiveTable() {
    const table = document.querySelector('.ppb-table');
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