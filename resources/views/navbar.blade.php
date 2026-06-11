<header class="topbar">
    <nav class="nav-inner">
        <a class="brand" href="{{ route('home') }}">
            <span class="brand-mark">JR</span>
            <span>Cafe Jejak Rasa</span>
        </a>

        <div class="nav-links">
            <a class="nav-link" href="{{ route('home') }}">Home</a>
            <a class="nav-link" href="{{ route('menu.index') }}">Menu</a>

            @auth('pelanggan')
                <a class="nav-link" href="{{ route('pelanggan.pesan') }}">Pesan</a>
                <form action="{{ route('pelanggan.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-button">Logout</button>
                </form>
            @else
                <a class="nav-link" href="{{ route('pelanggan.login') }}">Login Pelanggan</a>
            @endauth

            @auth('web')
                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-button">Logout Admin</button>
                </form>
            @else
                <a class="nav-link" href="{{ route('admin.login') }}">Login Admin</a>
            @endauth
        </div>
    </nav>
</header>

