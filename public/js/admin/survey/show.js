document.addEventListener('DOMContentLoaded', function() {
    // =====================
    // ALERT CLOSE
    // =====================
    document.querySelectorAll('.alert-close').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const alert = this.closest('.survey-alert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(function() { alert.remove(); }, 300);
            }
        });
    });

    // =====================
    // STAR HOVER EFFECT
    // =====================
    document.querySelectorAll('.rating-row').forEach(function(row) {
        const stars = row.querySelectorAll('.star');
        if (!stars.length) return;

        stars.forEach(function(star, index) {
            star.addEventListener('mouseenter', function() {
                stars.forEach(function(s, i) {
                    if (i <= index) {
                        s.style.color = '#f59e0b';
                        s.style.transform = 'scale(1.2)';
                    } else {
                        s.style.color = '#e5e7eb';
                        s.style.transform = 'scale(1)';
                    }
                });
            });
        });

        row.querySelector('.rating-stars').addEventListener('mouseleave', function() {
            stars.forEach(function(s) {
                s.style.color = '';
                s.style.transform = '';
            });
        });
    });

    // =====================
    // RATING ROW PROGRESS BAR (visual)
    // =====================
    document.querySelectorAll('.rating-row[data-rating]').forEach(function(row) {
        const rating = parseFloat(row.dataset.rating) || 0;
        const percentage = (rating / 5) * 100;

        // Tambah progress bar background
        row.style.position = 'relative';
        row.style.overflow = 'hidden';

        const bar = document.createElement('div');
        bar.className = 'rating-progress-bar';
        bar.style.cssText = `
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: #4f46e5;
            border-radius: 0 0 0 12px;
            width: 0;
            transition: width 0.8s ease ${row.style.animationDelay || '0s'};
            opacity: 0.3;
        `;
        row.appendChild(bar);

        setTimeout(function() {
            bar.style.width = percentage + '%';
        }, 100);
    });
});