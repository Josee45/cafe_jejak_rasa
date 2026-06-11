<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cafe Jejak Rasa')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f7f2ea;
            --surface: #fffdf9;
            --surface-2: #f0e7dc;
            --text: #2a211b;
            --muted: #766a5f;
            --brand: #8a4f2d;
            --brand-dark: #60351f;
            --accent: #0f766e;
            --line: #e8ddd0;
            --danger: #b42318;
            --warning: #b7791f;
            --shadow: 0 18px 45px rgba(42, 33, 27, .09);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, Arial, sans-serif;
            color: var(--text);
            background:
                linear-gradient(180deg, rgba(255,255,255,.64), rgba(247,242,234,.9) 280px),
                var(--bg);
        }

        a {
            color: inherit;
        }

        img {
            max-width: 100%;
            display: block;
        }

        .site-shell {
            min-height: 100vh;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            border-bottom: 1px solid rgba(232, 221, 208, .86);
            background: rgba(255, 253, 249, .92);
            backdrop-filter: blur(14px);
        }

        .nav-inner {
            width: min(1160px, calc(100% - 32px));
            min-height: 72px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            text-decoration: none;
            letter-spacing: 0;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            color: #fff;
            background: linear-gradient(135deg, var(--brand), var(--accent));
            box-shadow: 0 10px 24px rgba(96, 53, 31, .18);
        }

        .nav-links {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 8px;
        }

        .nav-link,
        .nav-button {
            border: 0;
            border-radius: 8px;
            padding: 10px 13px;
            color: var(--muted);
            background: transparent;
            font: inherit;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .nav-link:hover,
        .nav-button:hover {
            color: var(--brand-dark);
            background: var(--surface-2);
        }

        .container {
            width: min(1160px, calc(100% - 32px));
            margin: 0 auto;
        }

        .page {
            padding: 34px 0 56px;
        }

        .hero {
            min-height: 430px;
            display: grid;
            align-items: end;
            color: #fff;
            background:
                linear-gradient(90deg, rgba(31, 22, 16, .78), rgba(31, 22, 16, .32)),
                url("{{ asset('images/menu/caramel_machiatto.png') }}") center/cover;
        }

        .hero-content {
            width: min(1160px, calc(100% - 32px));
            margin: 0 auto;
            padding: 88px 0 56px;
        }

        .eyebrow {
            margin: 0 0 10px;
            color: var(--accent);
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .hero .eyebrow {
            color: #f8d8a8;
        }

        h1,
        h2,
        h3 {
            margin: 0;
            letter-spacing: 0;
            line-height: 1.12;
        }

        h1 {
            max-width: 740px;
            font-size: clamp(42px, 7vw, 78px);
        }

        h2 {
            font-size: clamp(26px, 4vw, 42px);
        }

        h3 {
            font-size: 20px;
        }

        .lead {
            max-width: 650px;
            margin: 18px 0 0;
            color: rgba(255, 255, 255, .88);
            font-size: 18px;
            line-height: 1.7;
        }

        .section-head,
        .page-head {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .section-head p,
        .page-head p {
            max-width: 560px;
            margin: 8px 0 0;
            color: var(--muted);
            line-height: 1.65;
        }

        .grid {
            display: grid;
            gap: 18px;
        }

        .menu-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .stat-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .menu-card,
        .panel {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .menu-card {
            overflow: hidden;
        }

        .menu-img {
            width: 100%;
            aspect-ratio: 4 / 3;
            object-fit: cover;
            background: var(--surface-2);
        }

        .menu-body {
            padding: 16px;
        }

        .menu-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 12px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            border-radius: 999px;
            padding: 5px 10px;
            color: var(--brand-dark);
            background: #f4dfc5;
            font-size: 12px;
            font-weight: 800;
        }

        .badge.alt {
            color: #075985;
            background: #e0f2fe;
        }

        .badge.ok {
            color: #166534;
            background: #dcfce7;
        }

        .price {
            margin: 10px 0 0;
            color: var(--brand);
            font-size: 18px;
            font-weight: 800;
        }

        .muted {
            color: var(--muted);
        }

        .actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            border: 1px solid transparent;
            border-radius: 8px;
            padding: 10px 15px;
            color: #fff;
            background: var(--brand);
            font: inherit;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
        }

        .btn:hover {
            background: var(--brand-dark);
        }

        .btn.secondary {
            color: var(--text);
            background: var(--surface);
            border-color: var(--line);
        }

        .btn.secondary:hover {
            background: var(--surface-2);
        }

        .btn.danger {
            background: var(--danger);
        }

        .btn.full {
            width: 100%;
        }

        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 22px;
        }

        .filter-pill {
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 9px 14px;
            color: var(--muted);
            background: var(--surface);
            font-weight: 800;
            text-decoration: none;
        }

        .filter-pill.active,
        .filter-pill:hover {
            color: #fff;
            background: var(--accent);
            border-color: var(--accent);
        }

        .panel {
            padding: 20px;
        }

        .form-card,
        .auth-card,
        .receipt-card {
            width: min(560px, calc(100% - 32px));
            margin: 38px auto;
            padding: 24px;
        }

        .receipt-card {
            width: min(760px, calc(100% - 32px));
        }

        .field {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: 800;
        }

        input,
        select {
            width: 100%;
            min-height: 44px;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 10px 12px;
            color: var(--text);
            background: #fff;
            font: inherit;
        }

        input:focus,
        select:focus {
            outline: 3px solid rgba(15, 118, 110, .18);
            border-color: var(--accent);
        }

        .qty-row {
            display: grid;
            grid-template-columns: 88px 1fr;
            gap: 10px;
            margin-top: 14px;
        }

        .alert {
            border-radius: 8px;
            padding: 13px 15px;
            margin-bottom: 18px;
            color: #14532d;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
        }

        .alert.error {
            color: #7f1d1d;
            background: #fee2e2;
            border-color: #fecaca;
        }

        .empty {
            grid-column: 1 / -1;
            padding: 32px;
            text-align: center;
            color: var(--muted);
            border: 1px dashed var(--line);
            border-radius: 8px;
            background: rgba(255,255,255,.58);
        }

        .table-wrap {
            overflow-x: auto;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            vertical-align: top;
        }

        th {
            color: var(--brand-dark);
            background: #f8efe4;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        tr:last-child td {
            border-bottom: 0;
        }

        .thumb {
            width: 72px;
            height: 54px;
            object-fit: cover;
            border-radius: 8px;
            background: var(--surface-2);
        }

        .cart-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            gap: 22px;
            align-items: start;
        }

        .cart-list {
            display: grid;
            gap: 12px;
            margin: 14px 0 0;
            padding: 0;
            list-style: none;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--line);
        }

        .cart-item:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .receipt-meta {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin: 20px 0;
        }

        .meta-box {
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 14px;
            background: #fffaf3;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-top: 18px;
            padding-top: 18px;
            border-top: 2px solid var(--line);
            font-size: 20px;
            font-weight: 800;
        }

        @media (max-width: 980px) {
            .menu-grid,
            .stat-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .cart-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 680px) {
            .nav-inner {
                align-items: flex-start;
                flex-direction: column;
                padding: 14px 0;
                gap: 12px;
            }

            .nav-links {
                justify-content: flex-start;
            }

            .hero {
                min-height: 390px;
            }

            .section-head,
            .page-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .menu-grid,
            .stat-grid,
            .receipt-meta {
                grid-template-columns: 1fr;
            }

            .qty-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="site-shell">
        @include('navbar')
        @yield('content')
    </div>
</body>
</html>
