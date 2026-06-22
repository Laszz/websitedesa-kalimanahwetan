document.addEventListener('DOMContentLoaded', function() {
    // Animasi icon
    const icon = document.querySelector('.thanks-icon');
    if (icon) {
        icon.style.opacity = '0';
        icon.style.transform = 'scale(0.5)';
        
        requestAnimationFrame(() => {
            icon.style.transition = 'all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1)';
            icon.style.opacity = '1';
            icon.style.transform = 'scale(1)';
        });
    }

    // Animasi card
    const card = document.querySelector('.thanks-card');
    if (card) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        requestAnimationFrame(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        });
    }
});