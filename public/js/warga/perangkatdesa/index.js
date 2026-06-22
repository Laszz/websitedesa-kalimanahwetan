document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll(".perangkat-card");

    // Staggered animation - batasi max delay biar ngga kelamaan
    cards.forEach((card, index) => {
        // Max delay 1.2 detik (8 card pertama), sisanya langsung muncul
        const delay = Math.min(index * 0.12, 1.2);
        card.style.animationDelay = `${delay}s`;
    });

    // Efek klik - active state yang ngga nabrak hover
    cards.forEach(card => {
        card.addEventListener("click", () => {
            // Hapus dulu hover effect sementara
            card.style.transition = "transform 0.15s ease";
            card.classList.add("active");
            
            setTimeout(() => {
                card.classList.remove("active");
                // Restore transition hover
                card.style.transition = "";
            }, 200);
        });
    });

    // Lazy loading image biar ngga broken
    const images = document.querySelectorAll(".perangkat-card .foto");
    images.forEach(img => {
        img.addEventListener("error", () => {
            img.src = "/images/default-avatar.png";
        });
    });
});