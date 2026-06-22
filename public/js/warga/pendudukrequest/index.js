document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById('searchInput');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const tableRows = document.querySelectorAll('.request-row');
    const mobileCards = document.querySelectorAll('.request-card');
    const noResults = document.getElementById('noResults');
    
    let currentFilter = 'all';
    let currentSearch = '';

    // Toast auto-hide
    const toast = document.getElementById('toastNotif');
    if (toast) {
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-20px)';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }

    // Filter function
    function filterData() {
        let visibleCount = 0;

        // Filter table rows
        tableRows.forEach(row => {
            const status = row.dataset.status;
            const layanan = row.dataset.layanan;
            const matchesFilter = currentFilter === 'all' || status === currentFilter;
            const matchesSearch = layanan.includes(currentSearch.toLowerCase());

            if (matchesFilter && matchesSearch) {
                row.classList.remove('hidden-row');
                visibleCount++;
            } else {
                row.classList.add('hidden-row');
            }
        });

        // Filter mobile cards
        mobileCards.forEach(card => {
            const status = card.dataset.status;
            const layanan = card.dataset.layanan;
            const matchesFilter = currentFilter === 'all' || status === currentFilter;
            const matchesSearch = layanan.includes(currentSearch.toLowerCase());

            if (matchesFilter && matchesSearch) {
                card.classList.remove('hidden-card');
            } else {
                card.classList.add('hidden-card');
            }
        });

        // Show/hide no results
        if (visibleCount === 0 && (tableRows.length > 0 || mobileCards.length > 0)) {
            noResults.style.display = 'block';
        } else {
            noResults.style.display = 'none';
        }
    }

    // Search input
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            currentSearch = e.target.value;
            filterData();
        });
    }

    // Filter buttons
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentFilter = btn.dataset.filter;
            filterData();
        });
    });

    // Add stagger animation to cards
    const cards = document.querySelectorAll('.request-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.05}s`;
    });

    console.log("✨ Riwayat Pengajuan loaded with modern features");
});