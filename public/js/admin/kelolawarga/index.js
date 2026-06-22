document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById('searchInput');
    const filterRw = document.getElementById('filterRw');
    const filterRt = document.getElementById('filterRt');
    const tableRows = document.querySelectorAll('.warga-row');
    const mobileCards = document.querySelectorAll('.warga-card-item');
    const noResults = document.getElementById('noResults');
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

    // Confirm delete
    window.confirmDelete = function(event) {
        const name = event.target.closest('.warga-row, .warga-card-item')?.querySelector('.warga-name, .card-name')?.textContent || 'warga ini';
        return confirm(`Yakin ingin menghapus data ${name}?`);
    };

    // Filter function
    function filterData() {
        const search = searchInput.value.toLowerCase();
        const rw = filterRw.value;
        const rt = filterRt.value;
        let visibleCount = 0;

        // Filter table rows
        tableRows.forEach(row => {
            const name = row.dataset.name;
            const nik = row.dataset.nik;
            const alamat = row.dataset.alamat;
            const rowRw = row.dataset.rw;
            const rowRt = row.dataset.rt;

            const matchesSearch = name.includes(search) || nik.includes(search) || alamat.includes(search);
            const matchesRw = !rw || rowRw === rw;
            const matchesRt = !rt || rowRt === rt;

            if (matchesSearch && matchesRw && matchesRt) {
                row.classList.remove('hidden-row');
                visibleCount++;
            } else {
                row.classList.add('hidden-row');
            }
        });

        // Filter mobile cards
        mobileCards.forEach(card => {
            const name = card.dataset.name;
            const nik = card.dataset.nik;
            const alamat = card.dataset.alamat;
            const cardRw = card.dataset.rw;
            const cardRt = card.dataset.rt;

            const matchesSearch = name.includes(search) || nik.includes(search) || alamat.includes(search);
            const matchesRw = !rw || cardRw === rw;
            const matchesRt = !rt || cardRt === rt;

            if (matchesSearch && matchesRw && matchesRt) {
                card.classList.remove('hidden-card');
            } else {
                card.classList.add('hidden-card');
            }
        });

        // Show/hide no results
        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    }

    // Event listeners
    if (searchInput) searchInput.addEventListener('input', filterData);
    if (filterRw) filterRw.addEventListener('change', filterData);
    if (filterRt) filterRt.addEventListener('change', filterData);

    // Stagger animation for cards
    mobileCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.05}s`;
    });

    // Row click highlight
    tableRows.forEach(row => {
        row.addEventListener('click', (e) => {
            if (e.target.closest('.btn-action, .delete-form')) return;
            row.style.backgroundColor = '#e0e7ff';
            setTimeout(() => {
                row.style.backgroundColor = '';
            }, 300);
        });
    });

    console.log("✨ Admin Kelola Warga loaded");
});