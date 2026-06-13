<header class="topbar">
    <nav class="nav-inner">
        <a class="brand" href="{{ route('home') }}">
            <span class="brand-mark">JR</span>
            <span>Cafe Jejak Rasa</span>
        </a>

        <div class="nav-links">
            <div class="nav-menu">
                <a class="nav-link" href="{{ route('home') }}">Home</a>

                @auth('pelanggan')
                    <a class="nav-link" href="{{ route('menu.index') }}">Menu</a>
                    <a class="nav-link" href="{{ route('pelanggan.pesanan.riwayat') }}">Pesanan Saya</a>
                @endauth

                @auth('web')
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    <a class="nav-link" href="{{ route('data.menu') }}">Data Menu</a>
                    <a class="nav-link" href="{{ route('data.pesanan') }}">Pesanan</a>
                    <a class="nav-link" href="{{ route('data.pelanggan') }}">Pelanggan</a>
                @endauth
            </div>

            <div class="nav-actions">
                @if(auth('pelanggan')->check())
                    <span class="account-pill">
                        <span>Pelanggan</span>
                        <strong>{{ auth('pelanggan')->user()->name }}</strong>
                    </span>
                    <a class="nav-link nav-cta" href="{{ route('pelanggan.pesan') }}">Pesan</a>
                    <form action="{{ route('pelanggan.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-button">Logout</button>
                    </form>
                @elseif(auth('web')->check())
                    <span class="account-pill">
                        <span>Admin</span>
                        <strong>{{ auth('web')->user()->name }}</strong>
                    </span>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-button">Logout</button>
                    </form>
                @else
                    <a class="nav-link nav-cta" href="{{ route('pelanggan.login') }}">Login</a>
                @endif
            </div>
        </div>
    </nav>
</header>

