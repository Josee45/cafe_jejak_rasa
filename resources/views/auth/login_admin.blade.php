<!DOCTYPE html>
<html>
<head>
    <title>Login Admin - Cafe Jejak Rasa</title>
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#f4f1ed; }
        .wrap { width: 420px; margin: 60px auto; background:white; padding: 24px; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.15); }
        h2 { text-align:center; color:#6b432c; margin-top:0; }
        label { font-weight:bold; }
        input { width:100%; padding:10px; margin:8px 0 15px; border:1px solid #ccc; border-radius:8px; }
        button { width:100%; background:#6b432c; color:white; padding:10px; border:none; border-radius:8px; cursor:pointer; font-weight:bold; }
        .error { background:#f8d7da; color:#721c24; padding:10px; border-radius:8px; margin-bottom:12px; }
        a { color:#6b432c; text-decoration:none; }
    </style>
</head>
<body>
<div class="wrap">
    <h2>Login Admin</h2>

    @if($errors->any())
        <div class="error">
            <ul style="margin:0;padding-left:18px;">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>

