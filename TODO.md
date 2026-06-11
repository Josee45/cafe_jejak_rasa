# TODO - cafe_jejak_rasa (dashboard/data_menu/data_pesanan/pesan/proses_pesan/struk/login_pelanggan)

## Step 1 (done)
- Create authentication guard + login/logout route for pelanggan (akun terpisah).


## Step 2
- Add migrations for pesanan + pesanan_items.
- Create models: Pesanan, PesananItem.

## Step 3
- Add routes for: home, pesanan (customer ordering), proses_pesan, struk, data_menu, data_pesanan, dashboard.

## Step 4
- Add controllers: PesananController, StrukController, PelangganAuthController (if needed).

## Step 5
- Create navbar component and Blade views:
  - resources/views/navbar.blade.php
  - resources/views/dashboard.blade.php
  - resources/views/data_menu.blade.php
  - resources/views/data_pesanan.blade.php
  - resources/views/pesan.blade.php
  - resources/views/proses_pesan.blade.php
  - resources/views/struk.blade.php
  - resources/views/index.blade.php (landing)
  - resources/views/auth/login_pelanggan.blade.php

## Step 6
- Update existing menu/home views to link to customer ordering flow.

## Step 7
- Run migrations and quick manual test (browser):
  - pelanggan login -> pesan -> struk
  - admin dashboard -> data_pesanan

