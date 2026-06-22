document.addEventListener('DOMContentLoaded', function () {
    // Timeline animation
    const timelineItems = document.querySelectorAll('.timeline-item');
    
    timelineItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, index * 150);
    });

    // Back button hover effect
    const backBtn = document.querySelector('.btn-back');
    if (backBtn) {
        backBtn.addEventListener('mouseenter', () => {
            backBtn.style.transform = 'translateX(-4px)';
        });
        
        backBtn.addEventListener('mouseleave', () => {
            backBtn.style.transform = 'translateX(0)';
        });
    }

    // Ajukan button pulse effect
    const ajukanBtn = document.querySelector('.btn-ajukan');
    if (ajukanBtn) {
        ajukanBtn.addEventListener('mouseenter', () => {
            ajukanBtn.style.transform = 'translateY(-3px)';
        });
        
        ajukanBtn.addEventListener('mouseleave', () => {
            ajukanBtn.style.transform = 'translateY(0)';
        });
    }

    // Smooth scroll for any anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});