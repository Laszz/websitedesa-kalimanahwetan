document.addEventListener("DOMContentLoaded", function () {

    console.log("✅ Admin Sidebar Loaded");

    // ==========================
    // ELEMENT
    // ==========================
    const sidebar = document.getElementById("adminSidebar");
    const toggleBtn = document.getElementById("sidebarToggle");
    const overlay = document.getElementById("sidebarOverlay");
    const closeBtn = document.querySelector(".sidebar-close-btn");

    // ==========================
    // SIDEBAR
    // ==========================
    function openSidebar() {
        sidebar.classList.add("active");

        if (overlay) {
            overlay.classList.add("active");
        }

        document.body.classList.add("sidebar-open");
    }

    function closeSidebar() {
        sidebar.classList.remove("active");

        if (overlay) {
            overlay.classList.remove("active");
        }

        document.body.classList.remove("sidebar-open");
    }

    function toggleSidebar() {
        sidebar.classList.toggle("active");

        if (overlay) {
            overlay.classList.toggle("active");
        }

        document.body.classList.toggle("sidebar-open");
    }

    // ==========================
    // BUTTON
    // ==========================
    if (toggleBtn) {
        toggleBtn.addEventListener("click", toggleSidebar);
    }

    if (closeBtn) {
        closeBtn.addEventListener("click", closeSidebar);
    }

    if (overlay) {
        overlay.addEventListener("click", closeSidebar);
    }

    // ==========================
    // DROPDOWN MENU
    // ==========================
    const groups = document.querySelectorAll(".admin-menu-group");

    groups.forEach(group => {

        const toggle = group.querySelector(".admin-menu-toggle");

        if (!toggle) return;

        toggle.addEventListener("click", function () {

            const isOpen = group.classList.contains("open");

            // Tutup semua dropdown lain
            groups.forEach(item => {
                item.classList.remove("open");
            });

            // Kalau sebelumnya belum terbuka, buka
            if (!isOpen) {
                group.classList.add("open");
            }

        });

    });

    // ==========================
    // AUTO OPEN ACTIVE MENU
    // ==========================
    const activeSubmenu = document.querySelector(".admin-submenu-link.active");

    if (activeSubmenu) {

        const group = activeSubmenu.closest(".admin-menu-group");

        if (group) {
            group.classList.add("open");
        }

    }

    // ==========================
    // MOBILE
    // Tutup sidebar setelah klik menu
    // ==========================
    document.querySelectorAll(".admin-menu-link, .admin-submenu-link").forEach(link => {

        link.addEventListener("click", function () {

            if (window.innerWidth <= 768) {

                if (!this.classList.contains("admin-menu-toggle")) {
                    closeSidebar();
                }

            }

        });

    });

    // ==========================
    // ESC
    // ==========================
    document.addEventListener("keydown", function (e) {

        if (e.key === "Escape") {

            closeSidebar();

        }

    });

    // ==========================
    // SWIPE LEFT
    // ==========================
    let touchStartX = 0;

    if (sidebar) {

        sidebar.addEventListener("touchstart", function (e) {

            touchStartX = e.touches[0].clientX;

        });

        sidebar.addEventListener("touchend", function (e) {

            const touchEndX = e.changedTouches[0].clientX;

            if (touchStartX - touchEndX > 80) {

                closeSidebar();

            }

        });

    }

    // ==========================
    // DESKTOP
    // Sidebar selalu tampil
    // ==========================
    window.addEventListener("resize", function () {

        if (window.innerWidth > 768) {

            sidebar.classList.remove("active");

            if (overlay) {
                overlay.classList.remove("active");
            }

            document.body.classList.remove("sidebar-open");

        }

    });

});