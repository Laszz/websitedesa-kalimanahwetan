document.addEventListener("DOMContentLoaded", () => {
    const img = document.getElementById("beritaImage");
    const lightbox = document.getElementById("lightbox");
    const lightboxImg = document.getElementById("lightboxImg");
    const closeBtn = document.getElementById("closeLightbox");

    if (!img || !lightbox || !lightboxImg) return;

    // Buka lightbox
    img.addEventListener("click", () => {
        lightboxImg.src = img.src;
        lightbox.classList.add("active");
        document.body.style.overflow = "hidden";
    });

    // Tutup lightbox
    const closeLightbox = () => {
        lightbox.classList.remove("active");
        lightboxImg.src = "";
        document.body.style.overflow = "";
    };

    closeBtn.addEventListener("click", closeLightbox);

    lightbox.addEventListener("click", (e) => {
        if (e.target === lightbox || e.target === lightboxImg) {
            closeLightbox();
        }
    });

    // ESC untuk tutup
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && lightbox.classList.contains("active")) {
            closeLightbox();
        }
    });

    // Animasi scroll untuk deskripsi
    const deskripsi = document.querySelector('.deskripsi');
    if (deskripsi) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });
        
        deskripsi.style.opacity = '0';
        deskripsi.style.transform = 'translateY(20px)';
        deskripsi.style.transition = 'all 0.6s ease';
        observer.observe(deskripsi);
    }
});