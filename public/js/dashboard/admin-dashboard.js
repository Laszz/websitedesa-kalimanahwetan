document.addEventListener('DOMContentLoaded', () => {
    const submenuButtons = document.querySelectorAll('.admin-submenu-btn');
    const sidebar = document.getElementById('adminSidebar');
    const toggleBtn = document.getElementById('sidebarToggle');

    // Buat overlay hanya sekali
    let overlay = document.querySelector('.sidebar-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        document.body.appendChild(overlay);
    }

    // Fungsi bantu
    const openSidebar = () => {
        if (!sidebar) return;
        sidebar.classList.add('show');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';

        // Update toggle button state jika ada
        if (toggleBtn) {
            toggleBtn.classList.add('sidebar-open');
        }
    };

    const closeSidebar = () => {
        if (!sidebar) return;
        sidebar.classList.remove('show');
        overlay.classList.remove('active');
        document.body.style.overflow = '';

        // Update toggle button state jika ada
        if (toggleBtn) {
            toggleBtn.classList.remove('sidebar-open');
        }
    };

    const toggleSidebar = (e) => {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }

        if (sidebar?.classList.contains('show')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    };

    // Handle toggle submenu
    submenuButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();

            const submenu = btn.nextElementSibling;
            if (!submenu) return;

            // Tutup submenu lain
            document.querySelectorAll('.admin-submenu').forEach(menu => {
                if (menu !== submenu) {
                    menu.classList.remove('show');
                    // Reset icon rotation jika ada
                    const otherIcon = menu.previousElementSibling?.querySelector('i');
                    if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                }
            });

            // Toggle submenu yang diklik
            submenu.classList.toggle('show');

            // Rotate icon jika ada
            const icon = btn.querySelector('i');
            if (icon) {
                icon.style.transform = submenu.classList.contains('show') ?
                    'rotate(90deg)' : 'rotate(0deg)';
            }
        });
    });

    // Handle toggle sidebar (mobile)
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', toggleSidebar);

        // Tutup sidebar saat klik overlay
        overlay.addEventListener('click', (e) => {
            e.preventDefault();
            closeSidebar();
        });
    }

    // Tutup sidebar saat klik menu link di mobile
    const menuLinks = document.querySelectorAll('.admin-menu-link');
    menuLinks.forEach(link => {
        link.addEventListener('click', () => {
            // Cek jika di mobile
            if (window.innerWidth <= 768 && sidebar?.classList.contains('show')) {
                closeSidebar();
            }
        });
    });

    // Tutup sidebar saat klik submenu link di mobile
    const submenuLinks = document.querySelectorAll('.admin-submenu a');
    submenuLinks.forEach(link => {
        link.addEventListener('click', () => {
            // Cek jika di mobile
            if (window.innerWidth <= 768 && sidebar?.classList.contains('show')) {
                closeSidebar();
            }
        });
    });

    // Tutup sidebar saat resize ke desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });

    // Prevent sidebar menutup saat klik di dalam sidebar
    if (sidebar) {
        sidebar.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }

    // Handle escape key untuk tutup sidebar di mobile
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && window.innerWidth <= 768 && sidebar?.classList.contains('show')) {
            closeSidebar();
        }
    });

    // Prevent scroll pada body saat sidebar terbuka di mobile
    const handleTouchMove = (e) => {
        if (sidebar?.classList.contains('show') && window.innerWidth <= 768) {
            e.preventDefault();
        }
    };

    // Add touch event listeners untuk mobile
    document.addEventListener('touchmove', handleTouchMove, { passive: false });
});
