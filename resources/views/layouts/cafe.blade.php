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
            gap: 28px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            text-decoration: none;
            letter-spacing: 0;
            flex: 0 0 auto;
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
            flex: 1;
            justify-content: flex-end;
            gap: 18px;
            min-width: 0;
        }

        .nav-menu,
        .nav-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .nav-menu {
            justify-content: flex-end;
        }

        .nav-actions {
            justify-content: flex-end;
            padding-left: 16px;
            border-left: 1px solid var(--line);
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
            white-space: nowrap;
        }

        .nav-link:hover,
        .nav-button:hover {
            color: var(--brand-dark);
            background: var(--surface-2);
        }

        .nav-cta {
            color: #fff;
            background: var(--brand);
        }

        .nav-cta:hover {
            color: #fff;
            background: var(--brand-dark);
        }

        .account-pill {
            display: inline-flex;
            align-items: flex-start;
            flex-direction: column;
            justify-content: center;
            min-height: 40px;
            border: 1px solid rgba(15, 118, 110, .18);
            border-radius: 8px;
            padding: 7px 12px;
            color: var(--accent);
            background: rgba(15, 118, 110, .08);
            line-height: 1.15;
            max-width: 210px;
        }

        .account-pill span {
            color: var(--muted);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .account-pill strong {
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: var(--accent);
            font-size: 14px;
            font-weight: 800;
        }

        .container {
            width: min(1160px, calc(100% - 32px));
            margin: 0 auto;
        }

        .page {
            padding: 34px 0 56px;
        }

        .splash-page {
            min-height: calc(100vh - 72px);
            display: grid;
            align-items: center;
            padding: 34px 0;
            background:
                linear-gradient(180deg, rgba(255, 253, 249, .82), rgba(239, 247, 245, .92)),
                var(--bg);
        }

        .splash-hero {
            width: min(1160px, calc(100% - 32px));
            min-height: 620px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: minmax(0, 1.08fr) minmax(320px, .92fr);
            align-items: center;
            gap: 36px;
            padding: clamp(18px, 4vw, 34px) 0;
        }

        .splash-copy h1 {
            max-width: 720px;
            color: var(--text);
            font-size: clamp(42px, 6vw, 76px);
        }

        .splash-copy p:not(.eyebrow) {
            max-width: 620px;
            margin: 20px 0 0;
            color: var(--muted);
            font-size: 18px;
            line-height: 1.75;
        }

        .splash-copy .actions {
            margin-top: 28px;
        }

        .splash-visual {
            min-height: 500px;
            display: grid;
            grid-template-columns: minmax(0, 1fr) 168px;
            gap: 14px;
        }

        .splash-feature-card,
        .splash-mini-card {
            border: 1px solid rgba(255, 255, 255, .7);
            border-radius: 8px;
            background: var(--surface);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .splash-feature-card {
            align-self: stretch;
            display: grid;
            align-content: end;
            padding: 18px;
            color: #fff;
            background:
                linear-gradient(180deg, rgba(20, 16, 12, .04), rgba(20, 16, 12, .78)),
                #2a211b;
            position: relative;
        }

        .splash-feature-card img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .splash-feature-card div {
            position: relative;
            z-index: 1;
            display: grid;
            gap: 8px;
        }

        .splash-feature-card span {
            color: #bae6fd;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .splash-feature-card strong {
            font-size: 28px;
        }

        .splash-feature-card small {
            max-width: 320px;
            color: rgba(255, 255, 255, .84);
            font-size: 14px;
            line-height: 1.6;
        }

        .splash-stack {
            display: grid;
            gap: 14px;
        }

        .splash-mini-card {
            min-height: 0;
            display: grid;
            grid-template-rows: minmax(110px, 1fr) auto;
        }

        .splash-mini-card img {
            width: 100%;
            height: 100%;
            min-height: 110px;
            object-fit: cover;
            background: var(--surface-2);
        }

        .splash-mini-card div {
            display: grid;
            gap: 3px;
            padding: 10px;
        }

        .splash-mini-card strong {
            color: var(--text);
            font-size: 14px;
        }

        .splash-mini-card small {
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
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

        .customer-note {
            display: inline-flex;
            align-items: center;
            min-height: 36px;
            margin: 18px 0 0;
            border: 1px solid rgba(255, 255, 255, .24);
            border-radius: 8px;
            padding: 8px 12px;
            color: #fff7ed;
            background: rgba(255, 253, 249, .14);
            font-weight: 800;
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
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
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

        .badge.warn {
            color: #92400e;
            background: #fef3c7;
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

        .btn.light {
            color: #fff;
            background: rgba(255, 255, 255, .14);
            border-color: rgba(255, 255, 255, .28);
        }

        .btn.light:hover {
            background: rgba(255, 255, 255, .24);
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

        .customer-stat-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            margin-bottom: 18px;
        }

        .mini-stat {
            display: grid;
            gap: 8px;
        }

        .mini-stat span {
            color: var(--muted);
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .mini-stat strong {
            color: var(--brand-dark);
            font-size: 24px;
        }

        .data-panel {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--surface);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .data-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 18px;
            border-bottom: 1px solid var(--line);
            background: linear-gradient(135deg, #fffdf9, #eef7f5);
        }

        .data-toolbar h3 {
            margin: 0;
        }

        .table-search {
            width: min(320px, 100%);
            margin: 0;
        }

        .table-search span {
            display: block;
            margin-bottom: 7px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .data-table tbody tr {
            transition: background .18s ease;
        }

        .data-table tbody tr:hover {
            background: #fff8ef;
        }

        .customer-cell {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 190px;
        }

        .customer-cell span {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            color: #fff;
            background: linear-gradient(135deg, var(--accent), #2563eb);
            font-weight: 900;
        }

        .form-card,
        .auth-card,
        .receipt-card {
            width: min(560px, calc(100% - 32px));
            margin: 38px auto;
            padding: 24px;
        }

        .auth-page {
            width: min(1120px, calc(100% - 32px));
            min-height: calc(100vh - 72px);
            margin: 0 auto;
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(360px, 440px);
            align-items: center;
            gap: 34px;
            padding: 42px 0 56px;
        }

        .auth-intro {
            min-height: 520px;
            display: grid;
            align-content: end;
            border-radius: 8px;
            padding: clamp(28px, 4vw, 44px);
            color: #fff;
            background:
                linear-gradient(180deg, rgba(26, 20, 15, .08), rgba(26, 20, 15, .78)),
                url("{{ asset('images/menu/croissant.png') }}") center/cover;
            box-shadow: var(--shadow);
        }

        .auth-page-admin .auth-intro {
            background:
                linear-gradient(180deg, rgba(15, 23, 42, .18), rgba(15, 23, 42, .82)),
                url("{{ asset('images/menu/americano.png') }}") center/cover;
        }

        .auth-intro .eyebrow {
            color: #bae6fd;
        }

        .auth-intro h1 {
            max-width: 560px;
            color: #fff;
            font-size: clamp(34px, 5vw, 58px);
        }

        .auth-intro p:not(.eyebrow) {
            max-width: 520px;
            margin: 18px 0 0;
            color: rgba(255, 255, 255, .86);
            font-size: 17px;
            line-height: 1.7;
        }

        .auth-page .auth-card {
            width: 100%;
            margin: 0;
        }

        .auth-switch {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: 14px;
            line-height: 1.5;
        }

        .auth-switch.compact {
            margin-top: 10px;
            padding-top: 10px;
        }

        .auth-switch a {
            color: var(--accent);
            font-weight: 900;
            text-decoration: none;
            white-space: nowrap;
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

        .qty-row > * {
            min-width: 0;
        }

        .qty-row .btn {
            width: 100%;
            padding-inline: 12px;
            white-space: nowrap;
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

        .cart-layout .menu-grid {
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        }

        .cart-layout .qty-row {
            grid-template-columns: minmax(74px, 88px) minmax(96px, 1fr);
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

        .payment-box {
            margin-top: 22px;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 18px;
            background: #fffaf3;
        }

        .payment-box h3 {
            margin-bottom: 8px;
        }

        .payment-form {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-top: 16px;
        }

        .payment-form .btn {
            grid-column: 1 / -1;
        }

        .payment-option {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            min-height: 88px;
            margin: 0;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 13px;
            background: var(--surface);
            cursor: pointer;
        }

        .payment-option input {
            width: auto;
            min-height: auto;
            margin-top: 3px;
        }

        .payment-option span {
            display: grid;
            gap: 4px;
        }

        .payment-option small {
            color: var(--muted);
            font-weight: 600;
            line-height: 1.45;
        }

        @media (max-width: 980px) {
            .nav-inner {
                align-items: flex-start;
                flex-direction: column;
                padding: 14px 0;
                gap: 12px;
            }

            .nav-links {
                width: 100%;
                align-items: flex-start;
                justify-content: space-between;
            }

            .nav-menu {
                justify-content: flex-start;
            }

            .nav-actions {
                padding-left: 0;
                border-left: 0;
            }

            .menu-grid,
            .stat-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .customer-stat-grid {
                grid-template-columns: 1fr;
            }

            .data-toolbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .splash-hero,
            .auth-page {
                grid-template-columns: 1fr;
            }

            .splash-visual,
            .auth-intro {
                min-height: 340px;
            }

            .splash-visual {
                grid-template-columns: 1fr;
            }

            .splash-stack {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .cart-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 680px) {
            .nav-links {
                flex-direction: column;
                gap: 10px;
                justify-content: flex-start;
            }

            .nav-menu,
            .nav-actions {
                width: 100%;
            }

            .nav-actions {
                gap: 8px;
                justify-content: flex-start;
            }

            .account-pill {
                width: 100%;
                max-width: none;
            }

            .hero {
                min-height: 390px;
            }

            .splash-page {
                padding: 18px 0 34px;
            }

            .splash-hero {
                min-height: auto;
                padding: 24px;
            }

            .splash-visual {
                min-height: auto;
            }

            .splash-feature-card {
                min-height: 320px;
            }

            .splash-stack {
                grid-template-columns: 1fr;
            }

            .splash-mini-card {
                grid-template-columns: 112px 1fr;
                grid-template-rows: auto;
                min-height: 104px;
            }

            .splash-mini-card img {
                min-height: 104px;
            }

            .auth-page {
                padding: 22px 0 42px;
            }

            .auth-intro {
                min-height: 280px;
            }

            .auth-switch {
                align-items: flex-start;
                flex-direction: column;
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

            .payment-form {
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
