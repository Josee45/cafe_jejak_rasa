<article class="menu-card">
    <img class="menu-img" src="{{ $menu->image_url }}" alt="{{ $menu->nama_menu }}">
    <div class="menu-body">
        <div class="menu-top">
            <span class="badge">{{ $menu->kategori_label }}</span>
        </div>
        <h3>{{ $menu->nama_menu }}</h3>
        <p class="price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>

        @if(! empty($orderable))
            <form action="{{ route('pelanggan.cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                <div class="qty-row">
                    <input type="number" name="qty" value="1" min="1" required aria-label="Jumlah {{ $menu->nama_menu }}">
                    <button class="btn" type="submit">Tambah</button>
                </div>
            </form>
        @endif

        @if(! empty($manageable))
            <div class="actions" style="margin-top:14px;">
                <a href="{{ route('menu.edit', $menu->id) }}" class="btn secondary">Edit</a>
                <form action="{{ route('menu.destroy', $menu->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn danger" onclick="return confirm('Yakin ingin menghapus menu ini?')">Hapus</button>
                </form>
            </div>
        @endif
    </div>
</article>
