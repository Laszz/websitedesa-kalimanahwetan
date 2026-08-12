<aside class="admin-sidebar" id="adminSidebar">

    {{-- Header --}}
    <div class="admin-sidebar-header">
        <h2>Admin Panel</h2>
        <button class="sidebar-close-btn" aria-label="Tutup sidebar">
            ✕
        </button>
    </div>

    {{-- Content --}}
    <div class="admin-sidebar-content">

        <nav>

            {{-- ================= Dashboard ================= --}}
            <a href="{{ route('admin.dashboard') }}"
                class="admin-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            {{-- ================= Manajemen Warga ================= --}}
            <div
                class="admin-menu-group
                {{ request()->routeIs('admin.kelolawarga.*') || request()->routeIs('admin.kelolaakun.*') ? 'open' : '' }}">

                <button type="button" class="admin-menu-link admin-menu-toggle">
                    <span>Manajemen Warga</span>
                    <span class="toggle-icon">▶</span>
                </button>

                <div class="admin-submenu">

                    <a href="{{ route('admin.kelolawarga.index') }}"
                        class="admin-submenu-link {{ request()->routeIs('admin.kelolawarga.*') ? 'active' : '' }}">
                        Kelola Warga
                    </a>

                    <a href="{{ route('admin.kelolaakun.index') }}"
                        class="admin-submenu-link {{ request()->routeIs('admin.kelolaakun.*') ? 'active' : '' }}">
                        Kelola Akun Warga
                    </a>

                </div>
            </div>

            {{-- ================= Pelayanan ================= --}}
            <div
                class="admin-menu-group
                {{ request()->routeIs('admin.layananpenduduk.*') ||
                    request()->routeIs('admin.pendudukrequest.*') ||
                    request()->routeIs('admin.aduan.*') ||
                    request()->routeIs('admin.surveys.*')
                    ? 'open'
                    : '' }}">

                <button type="button" class="admin-menu-link admin-menu-toggle">
                    <span>Pelayanan</span>
                    <span class="toggle-icon">▶</span>
                </button>

                <div class="admin-submenu">

                    <a href="{{ route('admin.layananpenduduk.index') }}"
                        class="admin-submenu-link {{ request()->routeIs('admin.layananpenduduk.*') ? 'active' : '' }}">
                        Kelola Layanan Penduduk
                    </a>

                    <a href="{{ route('admin.pendudukrequest.index') }}"
                        class="admin-submenu-link {{ request()->routeIs('admin.pendudukrequest.*') ? 'active' : '' }}">
                        Pendaftaran Layanan Warga
                    </a>

                    <a href="{{ route('admin.aduan.index') }}"
                        class="admin-submenu-link {{ request()->routeIs('admin.aduan.*') ? 'active' : '' }}">
                        Kelola Aduan Warga
                    </a>

                    <a href="{{ route('admin.surveys.index') }}"
                        class="admin-submenu-link {{ request()->routeIs('admin.surveys.*') ? 'active' : '' }}">
                        Survey Kepuasan
                    </a>

                </div>
            </div>

            {{-- ================= Konten Website ================= --}}
            <div
                class="admin-menu-group
                {{ request()->routeIs('admin.berita.*') ||
                    request()->routeIs('admin.galeri.*') ||
                    request()->routeIs('admin.agenda.*')
                    ? 'open'
                    : '' }}">

                <button type="button" class="admin-menu-link admin-menu-toggle">
                    <span>Konten Website</span>
                    <span class="toggle-icon">▶</span>
                </button>

                <div class="admin-submenu">

                    <a href="{{ route('admin.berita.index') }}"
                        class="admin-submenu-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                        Kelola Berita
                    </a>

                    <a href="{{ route('admin.galeri.index') }}"
                        class="admin-submenu-link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                        Kelola Galeri
                    </a>

                    <a href="{{ route('admin.agenda.index') }}"
                        class="admin-submenu-link {{ request()->routeIs('admin.agenda.*') ? 'active' : '' }}">
                        Kelola Agenda
                    </a>

                </div>
            </div>

            {{-- ================= Profil Desa ================= --}}
            <div
                class="admin-menu-group
                {{ request()->routeIs('admin.perangkatdesa.*') ||
                    request()->routeIs('admin.apbdes.*') ||
                    request()->routeIs('admin.jenisbantuan.*') ||
                    request()->routeIs('admin.penerimabantuan.*')
                    ? 'open'
                    : '' }}">

                <button type="button" class="admin-menu-link admin-menu-toggle">
                    <span>Profil Desa</span>
                    <span class="toggle-icon">▶</span>
                </button>

                <div class="admin-submenu">

                    <a href="{{ route('admin.perangkatdesa.index') }}"
                        class="admin-submenu-link {{ request()->routeIs('admin.perangkatdesa.*') ? 'active' : '' }}">
                        Profil Perangkat Desa
                    </a>

                    <a href="{{ route('admin.apbdes.index') }}"
                        class="admin-submenu-link {{ request()->routeIs('admin.apbdes.*') ? 'active' : '' }}">
                        Kelola APBDes
                    </a>

                    <a href="{{ route('admin.jenisbantuan.index') }}"
                        class="admin-submenu-link {{ request()->routeIs('admin.jenisbantuan.*') ? 'active' : '' }}">
                        Jenis Bantuan
                    </a>

                    <a href="{{ route('admin.penerimabantuan.index') }}"
                        class="admin-submenu-link {{ request()->routeIs('admin.penerimabantuan.*') ? 'active' : '' }}">
                        Penerima Bantuan
                    </a>

                </div>
            </div>

        </nav>

    </div>

    {{-- Footer --}}
    <div class="admin-sidebar-footer">

        <a href="{{ route('logout') }}"
            class="admin-menu-link logout-link"
            onclick="event.preventDefault();document.getElementById('logout-form').submit();">

            Logout

        </a>

        <form id="logout-form"
            action="{{ route('logout') }}"
            method="POST"
            class="hidden">

            @csrf

        </form>

    </div>

</aside>