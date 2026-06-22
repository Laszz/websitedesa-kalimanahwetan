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

    // Confirm delete dengan nama warga
    window.confirmDelete = function(event) {
        const form = event.target.closest('.delete-form');
        const name = form?.dataset.name || 'permohonan ini';
        
        if (typeof Swal !== "undefined") {
            Swal.fire({
                title: "Yakin hapus permohonan?",
                text: `Permohonan dari "${name}" akan dihapus permanen!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ef4444",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Ya, hapus",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    const btn = form.querySelector('button[type="submit"]');
                    btn.classList.add('btn-loading');
                    btn.disabled = true;
                    form.submit();
                }
            });
            return false;
        } else {
            if (!confirm(`Yakin ingin menghapus permohonan dari "${name}"?\n\nTindakan ini tidak bisa dibatalkan.`)) {
                return false;
            }
            const btn = form.querySelector('button[type="submit"]');
            btn.classList.add('btn-loading');
            btn.disabled = true;
            return true;
        }
    };

    // Row click highlight
    const rows = document.querySelectorAll('.request-table tbody tr');
    rows.forEach((row) => {
        row.addEventListener('click', (e) => {
            if (e.target.closest('.btn-action, .delete-form')) return;
            rows.forEach((r) => r.classList.remove('highlight'));
            row.classList.add('highlight');
        });
    });

    console.log("✨ Admin Penduduk Request loaded");
});