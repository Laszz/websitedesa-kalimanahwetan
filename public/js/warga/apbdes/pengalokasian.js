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
    const toggleBidang = (bidangId) => {
        const content = document.getElementById('content-bidang-' + bidangId);
        const icon = document.getElementById('icon-bidang-' + bidangId);
        const header = content?.closest('.bidang-section')?.querySelector('.bidang-header');
        
        if (!content || !icon) return;

        const isOpen = content.classList.contains('open');

        // Close all (accordion behavior)
        document.querySelectorAll('.bidang-content.open').forEach(el => {
            el.classList.remove('open');
            el.closest('.bidang-section')?.querySelector('.bidang-header')?.classList.remove('active');
        });
        document.querySelectorAll('.toggle-icon.rotated').forEach(el => el.classList.remove('rotated'));

        if (!isOpen) {
            content.classList.add('open');
            icon.classList.add('rotated');
            header?.classList.add('active');
        }
    };

    // Attach click handlers
    document.querySelectorAll('.bidang-header').forEach(header => {
        header.addEventListener('click', () => {
            const bidangId = header.closest('.bidang-section')?.dataset.bidang;
            if (bidangId) toggleBidang(bidangId);
        });
    });

    // Open first bidang by default
    const firstBidang = document.querySelector('.bidang-section');
    if (firstBidang) {
        const bidangId = firstBidang.dataset.bidang;
        if (bidangId) toggleBidang(bidangId);
    }

    // ===== PROGRESS BAR (Intersection Observer) =====
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bar = entry.target;
                const targetWidth = parseFloat(bar.dataset.width) || 0;
                setTimeout(() => {
                    bar.style.width = targetWidth + '%';
                }, 200);
                progressObserver.unobserve(bar);
            }
        });
    }, { threshold: 0.3 });

    document.querySelectorAll('.progress-bar-mini').forEach(bar => {
        progressObserver.observe(bar);
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

    // ===== BIDANG SECTION ENTRANCE =====
    document.querySelectorAll('.bidang-section').forEach((section, index) => {
        section.style.opacity = '0';
        section.style.animation = `slideUp 0.5s ease ${index * 0.1}s forwards`;
    });
});