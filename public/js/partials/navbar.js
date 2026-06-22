/* ============================================
   NAVBAR JS - Desa Kalimanah Wetan
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menuToggle');
    const navLinks = document.getElementById('navLinks');

    // ================= MOBILE MENU =================
    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            menuToggle.classList.toggle('active');
            navLinks.classList.toggle('active');
        });

        // Tutup menu kalau klik link
        navLinks.querySelectorAll('a:not(.dropdown-toggle)').forEach(link => {
            link.addEventListener('click', () => {
                menuToggle.classList.remove('active');
                navLinks.classList.remove('active');
            });
        });
    }

    // Tutup menu kalau klik di luar
    document.addEventListener('click', function (e) {
        if (navLinks && navLinks.classList.contains('active')) {
            if (!navLinks.contains(e.target) && !menuToggle.contains(e.target)) {
                menuToggle.classList.remove('active');
                navLinks.classList.remove('active');
            }
        }
    });

    // ================= SUBMENU MOBILE =================
    document.querySelectorAll('.has-submenu').forEach(li => {
        const toggle = li.querySelector('.dropdown-toggle');
        const submenu = li.querySelector('.submenu');

        if (toggle && submenu) {
            toggle.addEventListener('click', function (e) {
                if (window.innerWidth < 1024) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Tutup submenu lain
                    document.querySelectorAll('.has-submenu .submenu.open').forEach(open => {
                        if (open !== submenu) {
                            open.classList.remove('open');
                            open.closest('.has-submenu').querySelector('.dropdown-toggle').classList.remove('active');
                        }
                    });

                    toggle.classList.toggle('active');
                    submenu.classList.toggle('open');
                }
            });
        }
    });

    // ================= HIDE NAVBAR ON SCROLL =================
    let lastScroll = 0;
    const navbar = document.querySelector('.navbar');

    window.addEventListener('scroll', () => {
        const current = window.scrollY;

        if (current > lastScroll && current > 100) {
            navbar.classList.add('hidden-nav');
        } else {
            navbar.classList.remove('hidden-nav');
        }

        lastScroll = current;
    });

    // ================= NOTIFIKASI =================
    const notifToggle = document.getElementById('notifToggle');
    const notifPanel = document.getElementById('notifPanel');

    if (notifToggle && notifPanel) {
        notifToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            notifPanel.classList.toggle('active');
        });

        document.addEventListener('click', function (e) {
            if (notifPanel.classList.contains('active')) {
                if (!notifToggle.contains(e.target) && !notifPanel.contains(e.target)) {
                    notifPanel.classList.remove('active');
                }
            }
        });
    }

    // ================= MARK AS READ =================
    document.querySelectorAll('.notif-item').forEach(item => {
        item.addEventListener('click', function (e) {
            const notifId = this.dataset.id;
            if (notifId && this.classList.contains('unread')) {
                e.preventDefault();

                fetch(`/notifikasi/read/${notifId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.classList.remove('unread');
                        this.classList.add('read');

                        const badge = document.querySelector('.notif-badge');
                        if (badge) {
                            let count = parseInt(badge.textContent) - 1;
                            count <= 0 ? badge.remove() : badge.textContent = count;
                        }

                        setTimeout(() => {
                            window.location.href = this.href;
                        }, 150);
                    }
                })
                .catch(() => {
                    window.location.href = this.href;
                });
            }
        });
    });
});