<!DOCTYPE html>
<html>
<head>
    <title>Proses Pesanan - Cafe Jejak Rasa</title>
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#f4f1ed; }
        .wrap { width: 600px; margin: 60px auto; background:white; padding: 25px; border-radius:12px; box-shadow:0 3px 10px rgba(0,0,0,0.15); }
        h2 { text-align:center; color:#6b432c; margin-top:0; }
        p { color:#555; text-align:center; }
        .btn { display:block; width:fit-content; margin:20px auto 0; background:#6b432c; color:white; padding:10px 14px; border-radius:8px; text-decoration:none; font-weight:bold; }
    </style>
</head>
<body>
<div class="wrap">
    <h2>Memproses Pesanan...</h2>
    <p>Silakan tunggu. Jika tidak otomatis, klik tombol di bawah.</p>
    <a class="btn" href="{{ route('pelanggan.pesan') }}">Kembali</a>
</div>
</body>
</html>

