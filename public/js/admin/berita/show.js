document.addEventListener('DOMContentLoaded', function() {
    // =====================
    // IMAGE ZOOM OVERLAY
    // =====================
    var gambar = document.querySelector('.gambar-detail');
    if (gambar) {
        gambar.addEventListener('click', function() {
            var overlay = document.createElement('div');
            overlay.className = 'img-overlay';

            var img = document.createElement('img');
            img.src = gambar.src;
            img.alt = gambar.alt || 'Gambar detail';

            overlay.appendChild(img);
            document.body.appendChild(overlay);

            // Tutup klik overlay
            overlay.addEventListener('click', function() {
                overlay.remove();
            });

            // Tutup dengan Escape key
            function handleEscape(e) {
                if (e.key === 'Escape') {
                    overlay.remove();
                    document.removeEventListener('keydown', handleEscape);
                }
            }
            document.addEventListener('keydown', handleEscape);
        });
    }

    // =====================
    // ALERT CLOSE
    // =====================
    document.querySelectorAll('.alert-close').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var alert = this.closest('.berita-alert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(function() { alert.remove(); }, 300);
            }
        });
    });

    // =====================
    // AUTO HIDE ALERT (5 detik)
    // =====================
    document.querySelectorAll('.berita-alert').forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(function() { alert.remove(); }, 300);
        }, 5000);
    });
});