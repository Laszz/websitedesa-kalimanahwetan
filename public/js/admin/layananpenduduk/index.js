document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById('searchInput');
    const filterKategori = document.getElementById('filterKategori');
    const filterStatus = document.getElementById('filterStatus');
    const tableRows = document.querySelectorAll('.layanan-row');
    const mobileCards = document.querySelectorAll('.layanan-card');
    const noResults = document.getElementById('noResults');

    // Confirm delete
    window.confirmDelete = function(event) {
        const name = event.target.closest('.layanan-row, .layanan-card')?.querySelector('.layanan-name, .card-name')?.textContent || 'layanan ini';
        return confirm(`Yakin ingin menghapus ${name}?`);
    };

    // Filter function
    function filterData() {
        const search = searchInput.value.toLowerCase();
        const kategori = filterKategori.value;
        const status = filterStatus.value;
        let visibleCount = 0;

        // Filter table rows
        tableRows.forEach(row => {
            const nama = row.dataset.nama;
            const rowKategori = row.dataset.kategori;
            const rowStatus = row.dataset.status;

            const matchesSearch = nama.includes(search);
            const matchesKategori = !kategori || rowKategori === kategori;
            const matchesStatus = !status || rowStatus === status;

            if (matchesSearch && matchesKategori && matchesStatus) {
                row.classList.remove('hidden-row');
                visibleCount++;
            } else {
                row.classList.add('hidden-row');
            }
        });

        // Filter mobile cards
        mobileCards.forEach(card => {
            const nama = card.dataset.nama;
            const cardKategori = card.dataset.kategori;
            const cardStatus = card.dataset.status;

            const matchesSearch = nama.includes(search);
            const matchesKategori = !kategori || cardKategori === kategori;
            const matchesStatus = !status || cardStatus === status;

            if (matchesSearch && matchesKategori && matchesStatus) {
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
    if (filterKategori) filterKategori.addEventListener('change', filterData);
    if (filterStatus) filterStatus.addEventListener('change', filterData);

    // Stagger animation
    mobileCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.05}s`;
    });

    console.log("Admin Kelola Layanan loaded");
});