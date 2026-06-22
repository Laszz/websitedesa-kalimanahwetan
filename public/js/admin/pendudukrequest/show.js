document.addEventListener('DOMContentLoaded', function() {
    const alertCloses = document.querySelectorAll('.alert-close');

    // Close alert
    alertCloses.forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.request-alert').style.display = 'none';
        });
    });

    // Auto-hide alert after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.request-alert').forEach(alert => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // Smooth scroll ke section kalau ada hash di URL
    if (window.location.hash) {
        const element = document.querySelector(window.location.hash);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // Track file views (bisa dipake buat analytics nanti)
    document.querySelectorAll('a[target="_blank"]').forEach(link => {
        link.addEventListener('click', function() {
            console.log('Viewing file:', this.href);
        });
    });

    // Info row hover effect
    const rows = document.querySelectorAll('.info-row');
    rows.forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.classList.add('info-row-hover');
        });
        row.addEventListener('mouseleave', () => {
            row.classList.remove('info-row-hover');
        });
    });

    console.log("✨ Penduduk Request Show loaded");
});