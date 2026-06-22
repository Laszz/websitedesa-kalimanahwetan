document.addEventListener('DOMContentLoaded', () => {
    
    // ===== COUNTER ANIMATION =====
    const animateCounter = (el, duration = 1200) => {
        const text = el.textContent.trim();
        // Cari angka dengan format: bisa ada titik ribuan dan koma decimal
        const match = text.match(/[\d.,]+/);
        if (!match) return;

        const raw = match[0];
        let target;
        
        // Deteksi format: kalau ada koma di belakang (sebelum %), itu decimal
        if (raw.includes(',') && raw.includes('.')) {
            // Format: 1.234.567,89 (titik ribuan, koma decimal)
            target = parseFloat(raw.replace(/\./g, '').replace(/,/g, '.'));
        } else if (raw.includes(',')) {
            // Cek posisi koma: kalau di 3 digit dari belakang, itu ribuan Kalau gak, itu decimal
            const parts = raw.split(',');
            if (parts[1] && parts[1].length === 3) {
                // Ribuan: 1,234 
                target = parseFloat(raw.replace(/,/g, ''));
            } else {
                // Decimal: 57,14 
                target = parseFloat(raw.replace(/,/g, '.'));
            }
        } else if (raw.includes('.')) {
            // Cek posisi titik: kalau di 3 digit dari belakang, itu ribuan
            const lastDot = raw.lastIndexOf('.');
            const afterDot = raw.length - lastDot - 1;
            if (afterDot === 3) {
                // Ribuan: 1.234 
                target = parseFloat(raw.replace(/\./g, ''));
            } else {
                target = parseFloat(raw);
            }
        } else {
            // Gak ada titik/koma, langsung parse
            target = parseFloat(raw);
        }
        
        if (isNaN(target)) return;

        const prefix = text.substring(0, text.indexOf(match[0]));
        const suffix = text.substring(text.indexOf(match[0]) + match[0].length);
        const startTime = performance.now();

        const step = (now) => {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = target * eased;
            
            // Format sesuai target: kalau target integer, tanpa decimal. Kalau decimal, 2 digit.
            const formatted = Number.isInteger(target) 
                ? new Intl.NumberFormat('id-ID').format(Math.floor(current))
                : new Intl.NumberFormat('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(current);
                
            el.textContent = prefix + formatted + suffix;
            if (progress < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    };

    // ===== PROGRESS BAR (Intersection Observer) =====
    const progressFill = document.querySelector('.progress-fill');
    if (progressFill) {
        const targetWidth = parseFloat(progressFill.dataset.width) || 0;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        progressFill.style.width = targetWidth + '%';
                    }, 200);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        observer.observe(progressFill);
    }

    // ===== CARD ENTRANCE ANIMATION =====
    const cards = document.querySelectorAll('.ringkasan-card, .menu-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.animation = `slideUp 0.5s ease ${index * 0.1}s forwards`;
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
});