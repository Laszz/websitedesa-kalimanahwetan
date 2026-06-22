document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");
    const searchResults = document.getElementById("searchResults");
    const defaultNews = document.getElementById("defaultNews");

    let timeout = null;

    const escapeHtml = (str) => {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    };

    // Animasi scroll untuk card
    const animateOnScroll = () => {
        const cards = document.querySelectorAll('.card-berita');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        cards.forEach(card => observer.observe(card));
    };

    // Jalankan animasi untuk card default
    animateOnScroll();

    searchInput.addEventListener("input", function () {
        clearTimeout(timeout);
        const q = this.value.trim();

        if (q.length < 2) {
            searchResults.innerHTML = "";
            defaultNews.style.display = "block";
            animateOnScroll();
            return;
        }

        searchResults.innerHTML = `
            <div class="loading-state">
                <div class="loading-spinner"></div>
                <p>Mencari berita...</p>
            </div>
        `;
        defaultNews.style.display = "none";

        timeout = setTimeout(() => {
            fetch(`/berita/search/ajax?q=${encodeURIComponent(q)}`)
                .then(res => {
                    if (!res.ok) throw new Error("Jaringan error");
                    return res.json();
                })
                .then(data => {
                    searchResults.innerHTML = "";

                    if (!data || data.length === 0) {
                        searchResults.innerHTML = `
                            <div class="empty-search">
                                <p>🔍 Tidak ada hasil untuk "${escapeHtml(q)}"</p>
                            </div>
                        `;
                        return;
                    }

                    data.forEach((item, index) => {
                        const card = document.createElement("div");
                        card.className = "card-berita";
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        card.style.transition = 'all 0.5s ease';
                        card.style.transitionDelay = `${index * 0.1}s`;
                        
                        const tanggal = new Date(item.tanggal).toLocaleDateString("id-ID", {
                            day: "2-digit",
                            month: "long",
                            year: "numeric"
                        });

                        card.innerHTML = `
                            <img src="/storage/${escapeHtml(item.gambar)}" 
                                 alt="${escapeHtml(item.judul)}"
                                 onerror="this.src='/images/no-image.png'">
                            <div class="card-body">
                                <span class="card-tanggal">${tanggal}</span>
                                <h3>${escapeHtml(item.judul)}</h3>
                                <p class="ringkasan">${escapeHtml(item.ringkasan.substring(0, 120))}...</p>
                                <a href="/berita/${escapeHtml(item.slug)}" class="btn-selengkapnya">
                                    Baca Selengkapnya →
                                </a>
                            </div>
                        `;
                        searchResults.appendChild(card);

                        // Trigger animasi
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 50);
                    });
                })
                .catch(() => {
                    searchResults.innerHTML = `
                        <div class="empty-search">
                            <p>⚠️ Terjadi kesalahan. Silakan coba lagi.</p>
                        </div>
                    `;
                });
        }, 400);
    });
});