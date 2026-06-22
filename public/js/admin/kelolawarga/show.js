document.addEventListener("DOMContentLoaded", () => {
    const alertCloses = document.querySelectorAll('.alert-close');

    // Close alert
    alertCloses.forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.warga-alert').style.display = 'none';
        });
    });

    // Auto-hide alert after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.warga-alert').forEach(alert => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // Info row hover effect via CSS class (cleaner than inline styles)
    const rows = document.querySelectorAll('.info-row');
    rows.forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.classList.add('info-row-hover');
        });
        row.addEventListener('mouseleave', () => {
            row.classList.remove('info-row-hover');
        });
    });

    console.log("✨ Detail Warga loaded");
});