document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin Sidebar loaded ✅');

    const sidebar = document.getElementById('adminSidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');
    const closeBtn = document.querySelector('.sidebar-close-btn');

    function toggleSidebar() {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        document.body.classList.toggle('sidebar-open');
    }

    // Buka sidebar
    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebar);
    }

    // Tutup sidebar (tombol X)
    if (closeBtn) {
        closeBtn.addEventListener('click', toggleSidebar);
    }

    // Tutup sidebar (klik overlay)
    if (overlay) {
        overlay.addEventListener('click', toggleSidebar);
    }

    // ===== Toggle Submenu APBDes =====
    const apbdesToggle = document.querySelector('.admin-menu-toggle');
    if (apbdesToggle) {
        apbdesToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const group = this.closest('.admin-menu-group');
            const submenu = group.querySelector('.admin-submenu');
            const icon = this.querySelector('.toggle-icon');
            
            if (group.classList.contains('open')) {
                // Tutup
                submenu.style.display = 'none';
                group.classList.remove('open');
            } else {
                // Buka
                submenu.style.display = 'flex';
                group.classList.add('open');
            }
        });
    }

    // Auto-open kalau ada active submenu
    const activeSubmenu = document.querySelector('.admin-submenu-link.active');
    if (activeSubmenu) {
        const group = activeSubmenu.closest('.admin-menu-group');
        if (group) {
            group.classList.add('open');
            const submenu = group.querySelector('.admin-submenu');
            if (submenu) submenu.style.display = 'flex';
        }
    }

    // Tutup sidebar pas klik menu di mobile (kecuali toggle submenu)
    document.querySelectorAll('.admin-menu-link:not(.admin-menu-toggle), .admin-submenu-link').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                toggleSidebar();
            }
        });
    });

    // Swipe left nutup sidebar
    let touchStartX = 0;
    if (sidebar) {
        sidebar.addEventListener('touchstart', function(e) {
            touchStartX = e.touches[0].clientX;
        });

        sidebar.addEventListener('touchend', function(e) {
            const touchEndX = e.changedTouches[0].clientX;
            if (touchStartX - touchEndX > 80) {
                if (sidebar.classList.contains('active')) {
                    toggleSidebar();
                }
            }
        });
    }

    // Escape key nutup sidebar
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('active')) {
            toggleSidebar();
        }
    });
});