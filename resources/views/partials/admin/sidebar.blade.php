<<aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar-header">
        <h2>Admin Panel</h2>
        <button class="sidebar-close-btn" aria-label="Tutup sidebar">✕</button>
    </div>

    <div class="admin-sidebar-content">
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="admin-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.kelolawarga.index') }}" class="admin-menu-link {{ request()->routeIs('admin.kelolawarga.*') ? 'active' : '' }}">Kelola Warga</a>
            <a href="{{ route('admin.kelolaakun.index') }}" class="admin-menu-link {{ request()->routeIs('admin.kelolaakun.*') ? 'active' : '' }}">Kelola Akun Warga</a>
            <a href="{{ route('admin.aduan.index') }}" class="admin-menu-link {{ request()->routeIs('admin.aduan.*') ? 'active' : '' }}">Kelola Aduan Warga</a>
            <a href="{{ route('admin.layananpenduduk.index') }}" class="admin-menu-link {{ request()->routeIs('admin.layananpenduduk.*') ? 'active' : '' }}">Kelola Layanan Penduduk</a>
            <a href="{{ route('admin.pendudukrequest.index') }}" class="admin-menu-link {{ request()->routeIs('admin.pendudukrequest.*') ? 'active' : '' }}">Kelola Pendaftaran Layanan Warga</a>
            <a href="{{ route('admin.surveys.index') }}" class="admin-menu-link {{ request()->routeIs('admin.surveys.*') ? 'active' : '' }}">Survey Kepuasan</a>
            <a href="{{ route('admin.berita.index') }}" class="admin-menu-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">Kelola Berita</a>
            <a href="{{ route('admin.galeri.index') }}" class="admin-menu-link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">Kelola Galeri</a>
            <a href="{{ route('admin.agenda.index') }}" class="admin-menu-link {{ request()->routeIs('admin.agenda.*') ? 'active' : '' }}">Kelola Agenda</a>
            <a href="{{ route('admin.perangkatdesa.index') }}" class="admin-menu-link {{ request()->routeIs('admin.perangkatdesa.*') ? 'active' : '' }}">Kelola Profil Perangkat Desa</a>
            <a href="{{ route('admin.apbdes.index') }}" class="admin-menu-link {{ request()->routeIs('admin.apbdes.*') ? 'active' : '' }}">Kelola APBDes</a>
            <a href="{{ route('admin.jenisbantuan.index') }}" class="admin-menu-link {{ request()->routeIs('admin.jenisbantuan.*') ? 'active' : '' }}">Jenis Bantuan</a>
            <a href="{{ route('admin.penerimabantuan.index') }}" class="admin-menu-link {{ request()->routeIs('admin.penerimabantuan.*') ? 'active' : '' }}">Penerima Bantuan</a>
        </nav>
    </div>

    <!-- Logout -->
    <div class="admin-sidebar-footer">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="admin-menu-link logout-link">
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</aside>