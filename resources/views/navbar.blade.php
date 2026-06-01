<div class="navbar">
    <div><b>Cafe Jejak Rasa</b></div>
    <div>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('menu.index') }}">Menu</a>

        @auth('pelanggan')
            <a href="{{ route('pelanggan.pesan') }}">Pesan</a>
            <form action="{{ route('pelanggan.logout') }}" method="POST" style="display:inline; margin-left:12px;">
                @csrf
                <button type="submit" style="background:none; border:none; color:white; font-weight:bold; cursor:pointer; padding:0;">Logout</button>
            </form>
        @else
            <a href="{{ route('pelanggan.login') }}">Login Pelanggan</a>
        @endauth

        @auth('web')
            <a href="{{ route('dashboard') }}" style="margin-left:12px;">Dashboard</a>
            <form action="{{ route('admin.logout') }}" method="POST" style="display:inline; margin-left:12px;">
                @csrf
                <button type="submit" style="background:none; border:none; color:white; font-weight:bold; cursor:pointer; padding:0;">Logout Admin</button>
            </form>
        @else
            <a href="{{ route('admin.login') }}" style="margin-left:12px;">Login Admin</a>
        @endauth


    </div>
</div>

<style>
.navbar {
    background: #6b432c;
    color: white;
    padding: 15px 80px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.navbar a {
    color: white;
    text-decoration: none;
    margin-left: 20px;
    font-weight: bold;
}
</style>

