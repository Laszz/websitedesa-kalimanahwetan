document.addEventListener('DOMContentLoaded', function() {
    console.log('Desa Kalimanah Wetan page loaded ✅');

    // --- Smooth scroll untuk anchor link ---
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // --- Animasi muncul saat scroll (fade-in) ---
    const elements = document.querySelectorAll('.card-custom, .video-frame, .calendar-container, #map');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    elements.forEach(el => observer.observe(el));

    // --- Auto-hide flash toast setelah 5 detik ---
    document.querySelectorAll('.flash-toast').forEach(toast => {
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100px)';
            toast.style.transition = 'all 0.4s ease';
            setTimeout(() => toast.remove(), 400);
        }, 5000);
    });

        // --- Leaflet Map ---
    const mapElement = document.getElementById('map');
    if (mapElement) {
        const balaiDesa = [-7.41509, 109.3396];
        const map = L.map('map').setView(balaiDesa, 18);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker(balaiDesa).addTo(map)
            .bindPopup("<b>Balai Desa Kalimanah Wetan</b><br>Jl. Raya Mayjen Sungkono No.142, Dusun 2<br>📍 <a href='https://www.google.com/maps?q=-7.41509,109.3396' target='_blank' style='color:blue;text-decoration:underline'>Buka di Google Maps</a>")
            .openPopup();
    }
});