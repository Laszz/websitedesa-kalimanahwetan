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
            el.textContent = prefix + new Intl.NumberFormat('id-ID').format(Math.floor(current)) + suffix;
            if (progress < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    };

    // ===== ACCORDION =====
    const toggleJenis = (jenis) => {
        const content = document.getElementById('content-' + jenis);
        const icon = document.getElementById('icon-' + jenis);
        const header = content?.closest('.jenis-section')?.querySelector('.jenis-header');
        
        if (!content || !icon) return;

        const isOpen = content.classList.contains('open');

        // Close all (optional accordion behavior)
        document.querySelectorAll('.jenis-content.open').forEach(el => {
            el.classList.remove('open');
            el.closest('.jenis-section')?.querySelector('.jenis-header')?.classList.remove('active');
        });
        document.querySelectorAll('.toggle-icon.rotated').forEach(el => el.classList.remove('rotated'));

        if (!isOpen) {
            content.classList.add('open');
            icon.classList.add('rotated');
            header?.classList.add('active');
        }
    };

    // Attach click handlers
    document.querySelectorAll('.jenis-header').forEach(header => {
        header.addEventListener('click', () => {
            const jenis = header.closest('.jenis-section')?.dataset.jenis;
            if (jenis) toggleJenis(jenis);
        });
    });

    // Open first jenis by default
    const firstJenis = document.querySelector('.jenis-section');
    if (firstJenis) {
        const jenisId = firstJenis.dataset.jenis;
        if (jenisId) toggleJenis(jenisId);
    }

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

    // ===== TOTAL CARD ENTRANCE =====
    document.querySelectorAll('.total-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.animation = `slideUp 0.5s ease ${index * 0.1}s forwards`;
    });
});