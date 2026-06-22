document.addEventListener("DOMContentLoaded", () => {
    const alertCloses = document.querySelectorAll('.alert-close');

    // Close alert
    alertCloses.forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.akun-alert').style.display = 'none';
        });
    });

    // Auto-hide alert after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.akun-alert').forEach(alert => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // Confirm delete
    window.confirmDelete = function(event) {
        const name = event.target.closest('.akun-row')?.querySelector('.user-name')?.textContent || 'akun ini';
        return confirm(`Yakin ingin menghapus akun ${name}?`);
    };

    // Row click highlight
    const rows = document.querySelectorAll('.akun-row');
    rows.forEach(row => {
        row.addEventListener('click', (e) => {
            if (e.target.closest('.btn-action, .delete-form, .status-select')) return;
            row.style.backgroundColor = '#e0e7ff';
            setTimeout(() => {
                row.style.backgroundColor = '';
            }, 300);
        });
    });

    console.log("✨ Admin Kelola Akun loaded");
});