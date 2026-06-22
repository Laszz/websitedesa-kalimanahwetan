<nav class="navbar">
    <div class="navbar-container">
        <!-- Logo -->
        <a href="/" class="navbar-logo">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo Desa">
            <span>Desa Kalimanah Wetan</span>
        </a>

        <!-- Right Side -->
        <div class="navbar-right">
            @auth
                <div class="notif-dropdown" id="notifDropdown">
                    <button id="notifToggle" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if(isset($notifications) && $notifications->where('is_read', false)->count() > 0)
                            <span class="notif-badge">
                                {{ $notifications->where('is_read', false)->count() }}
                            </span>
                        @endif
                    </button>

                    <div id="notifPanel" class="notif-panel">
                        <div class="notif-header">
                            <span>🔔 Notifikasi</span>
                            @if(isset($notifications) && $notifications->count() > 0)
                                <small>{{ $notifications->where('is_read', false)->count() }} belum dibaca</small>
                            @endif
                        </div>

                        <div class="notif-list">
                            @if(isset($notifications) && $notifications->count() > 0)
                                @foreach($notifications->take(5) as $notif)
                                    <a href="{{ $notif->url ?? route('warga.pendudukrequest.index') }}" 
                                       class="notif-item {{ $notif->is_read ? 'read' : 'unread' }}"
                                       data-id="{{ $notif->id }}">
                                        <div class="notif-text">{{ $notif->message }}</div>
                                        <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                                    </a>
                                @endforeach
                            @else
                                <div class="notif-empty">Tidak ada notifikasi</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endauth

            <!-- Mobile Menu Button -->
            <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

        <!-- Navbar Links -->
        <ul id="navLinks" class="nav-links">
            <!-- FIX: Beranda untuk warga ke dashboard -->
            <li>
                @auth
                    @if(auth()->user()->role === 'warga')
                        <a href="{{ route('warga.dashboard') }}">Beranda</a>
                    @else
                        <a href="/">Beranda</a>
                    @endif
                @else
                    <a href="/">Beranda</a>
                @endauth
            </li>

            <!-- Profil Desa -->
            <li class="has-submenu">
                <a href="#" class="dropdown-toggle">Profil Desa <span class="arrow">▾</span></a>
                <ul class="submenu">
                    <li><a href="{{ route('datadesa.index') }}">Data Desa</a></li>
                    <li><a href="{{ route('perangkatdesa.index') }}">Profil Perangkat Desa</a></li>
                    <li><a href="{{ route('visimisi.index') }}">Visi dan Misi</a></li>
                    <li><a href="{{ route('sejarahdesa.index') }}">Sejarah Desa</a></li>
                    <li><a href="{{ route('public.apbdes.index') }}">Informasi APBDes</a></li>
                </ul>
            </li>

            <!-- Menu Publik -->
            <li class="has-submenu">
                <a href="#" class="dropdown-toggle">Menu Publik <span class="arrow">▾</span></a>
                <ul class="submenu">
                    <li><a href="{{ route('agenda.index') }}">Agenda Kegiatan</a></li>
                    <li><a href="{{ route('berita.index') }}">Berita</a></li>
                    <li><a href="{{ route('galeri.index') }}">Galeri</a></li>
                    <li><a href="{{ route('aduan.public.index') }}">Aduan Masyarakat</a></li>
                    <li><a href="{{ route('public.penerimabantuan.index') }}">Penerima Bantuan</a></li>
                    <li><a href="{{ route('warga.survey.create') }}">Survei Kepuasan</a></li>
                </ul>
            </li>

            <!-- Layanan Penduduk -->
            <li class="has-submenu">
                <a href="#" class="dropdown-toggle">Layanan Penduduk <span class="arrow">▾</span></a>
                <ul class="submenu">
                    <li><a href="{{ route('warga.layananpenduduk.index') }}">Daftar Layanan</a></li>
                    @auth
                        @if(auth()->user()->role === 'warga')
                            <li><a href="{{ route('warga.pendudukrequest.index') }}">Riwayat Pengajuan</a></li>
                        @endif
                    @endauth
                </ul>
            </li>

            <!-- Auth -->
            @guest
                <li class="auth-buttons">
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn-register">Register</a>
                </li>
            @endguest

            @auth
                <li class="auth-buttons">
                    @if(auth()->user()->role === 'warga')
                        <a href="{{ route('warga.profile.index') }}" class="btn-profile">Profil</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </li>
            @endauth
        </ul>
    </div>
</nav>