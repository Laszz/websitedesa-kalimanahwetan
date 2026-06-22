document.addEventListener('DOMContentLoaded', function() {
    // =====================
    // CONFIRM DELETE
    // =====================
    window.confirmDelete = function(event) {
        var form = event.target;
        var name = form.dataset.name || 'foto ini';
        if (!confirm('Yakin mau hapus "' + name + '"?')) {
            event.preventDefault();
            return false;
        }
        return true;
    };

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
            img.className = 'zoomed-img';

            var closeBtn = document.createElement('button');
            closeBtn.className = 'close-btn';
            closeBtn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
            closeBtn.setAttribute('aria-label', 'Tutup');

            overlay.appendChild(closeBtn);
            overlay.appendChild(img);
            document.body.appendChild(overlay);

            function closeOverlay() {
                overlay.remove();
                document.removeEventListener('keydown', handleEscape);
            }

            function handleEscape(e) {
                if (e.key === 'Escape') {
                    closeOverlay();
                }
            }

            closeBtn.addEventListener('click', closeOverlay);
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    closeOverlay();
                }
            });
            document.addEventListener('keydown', handleEscape);
        });
    }

    // =====================
    // ALERT CLOSE
    // =====================
    document.querySelectorAll('.alert-close').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var alert = this.closest('.galeri-alert');
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
    document.querySelectorAll('.galeri-alert').forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(function() { alert.remove(); }, 300);
        }, 5000);
    });
});