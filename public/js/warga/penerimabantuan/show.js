/**
 * WARGA PENERIMA BANTUAN — SHOW JS
 * Animasi dan interaksi halaman detail
 */

document.addEventListener('DOMContentLoaded', function() {
    initCardAnimations();
});

/**
 * Animasi staggered untuk cards
 */
function initCardAnimations() {
    const cards = document.querySelectorAll('.wpb-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(card);
    });
}