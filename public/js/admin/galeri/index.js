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

    // =====================
    // COUNTER ANIMATION
    // =====================
    var counters = document.querySelectorAll('[data-counter]');

    counters.forEach(function(counter) {
        var target = parseInt(counter.textContent) || 0;
        var duration = 800;
        var startTime = performance.now();

        function update(currentTime) {
            var elapsed = currentTime - startTime;
            var progress = Math.min(elapsed / duration, 1);
            var ease = 1 - Math.pow(1 - progress, 3);
            counter.textContent = Math.round(target * ease);

            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }

        requestAnimationFrame(update);
    });

    // =====================
    // IMAGE ERROR FALLBACK (JS backup)
    // =====================
    document.querySelectorAll('.thumbnail').forEach(function(img) {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            var error = this.parentElement.querySelector('.thumb-error');
            if (error) error.style.display = 'flex';
        });
    });
});