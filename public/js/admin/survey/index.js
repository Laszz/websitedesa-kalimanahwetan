document.addEventListener('DOMContentLoaded', function() {
    // =====================
    // ANIMATE STAT CARDS
    // =====================
    const statCards = document.querySelectorAll('.stat-card');

    statCards.forEach(function(card, index) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';

        setTimeout(function() {
            card.style.transition = 'all 0.4s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // =====================
    // COUNTER ANIMATION
    // =====================
    const counters = document.querySelectorAll('[data-counter]');

    counters.forEach(function(counter) {
        const target = parseFloat(counter.textContent) || 0;
        const isDecimal = target % 1 !== 0;
        const duration = 800;
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const ease = 1 - Math.pow(1 - progress, 3);
            const current = target * ease;

            counter.textContent = isDecimal ? current.toFixed(1) : Math.round(current);

            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }

        requestAnimationFrame(update);
    });

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
});