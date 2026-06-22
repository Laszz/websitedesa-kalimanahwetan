document.addEventListener('DOMContentLoaded', () => {
    // ===== COUNTER ANIMATION =====
    const animateCounter = (el, duration = 1200) => {
        const text = el.textContent.trim();
        const match = text.match(/[\d.,]+/);
        if (!match) return;

        const raw = match[0].replace(/\./g, '').replace(/,/g, '.');
        const target = parseFloat(raw);
        if (isNaN(target)) return;

        const prefix = text.substring(0, text.indexOf(match[0]));
        const suffix = text.substring(text.indexOf(match[0]) + match[0].length);
        const startTime = performance.now();

        const step = (now) => {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = target * eased;
            
            let formatted;
            if (Number.isInteger(target)) {
                formatted = new Intl.NumberFormat('id-ID').format(Math.floor(current));
            } else {
                formatted = new Intl.NumberFormat('id-ID', { 
                    minimumFractionDigits: 2, 
                    maximumFractionDigits: 2 
                }).format(current);
            }
            
            el.textContent = prefix + formatted + suffix;
            if (progress < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    };

    // ===== PROGRESS BAR (Intersection Observer) =====
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bar = entry.target;
                const target = parseFloat(bar.dataset.width) || 0;
                setTimeout(() => {
                    bar.style.width = target + '%';
                    bar.setAttribute('data-label', target + '%');
                }, 200);
                progressObserver.unobserve(bar);
            }
        });
    }, { threshold: 0.3 });

    document.querySelectorAll('[data-width]').forEach(el => {
        progressObserver.observe(el);
    });

    // ===== GRAFIK BATANG (Intersection Observer) =====
    const grafikObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const fill = entry.target;
                const targetHeight = parseFloat(fill.dataset.height) || 0;
                setTimeout(() => {
                    fill.style.height = targetHeight + '%';
                }, 200);
                grafikObserver.unobserve(fill);
            }
        });
    }, { threshold: 0.3 });

    document.querySelectorAll('[data-height]').forEach(el => {
        grafikObserver.observe(el);
    });

    // ===== COUNTER TRIGGER (Intersection Observer) =====
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });

    document.querySelectorAll('[data-counter]').forEach(el => {
        counterObserver.observe(el);
    });

    // ===== CARD ENTRANCE =====
    document.querySelectorAll('.info-card, .progress-card, .realisasi-card, .grafik-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.animation = `slideUp 0.5s ease ${index * 0.1}s forwards`;
    });

    // ===== MOBILE TOOLTIP TAP =====
    const isTouchDevice = window.matchMedia('(pointer: coarse)').matches;
    
    if (isTouchDevice) {
        document.querySelectorAll('.batang-item').forEach(item => {
            item.addEventListener('click', (e) => {
                e.stopPropagation();
                // Close all others
                document.querySelectorAll('.batang-item').forEach(other => {
                    if (other !== item) other.classList.remove('tooltip-visible');
                });
                item.classList.toggle('tooltip-visible');
            });
        });

        // Close on outside click
        document.addEventListener('click', () => {
            document.querySelectorAll('.batang-item.tooltip-visible').forEach(item => {
                item.classList.remove('tooltip-visible');
            });
        });
    }
});