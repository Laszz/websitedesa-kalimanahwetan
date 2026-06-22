document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll(".card-sejarah");
    const texts = document.querySelectorAll(".fade-text");

    // Observer untuk teks & cards (unified)
    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const delay = entry.target.dataset.delay || 0;
                    setTimeout(() => {
                        entry.target.classList.add("show");
                        entry.target.classList.add("fade-up");
                    }, parseInt(delay));
                    obs.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1, rootMargin: "0px 0px -30px 0px" }
    );

    texts.forEach((el) => observer.observe(el));
    cards.forEach((card) => observer.observe(card));
});