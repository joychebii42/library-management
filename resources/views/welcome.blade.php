<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Library Management</title>

        <!-- Google font -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
            :root{--accent:#2563eb;--muted:#6b7280;--bg:#f8fafc}
            *{box-sizing:border-box}
            html,body{height:100%;margin:0;font-family:'Nunito',system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;background: linear-gradient(rgba(255, 255, 255, 0.25), rgba(255, 255, 255, 0.27)), url('/images/library-bg.jpg');color:#0f172a}
            a{color:var(--accent);text-decoration:none}
            .container{max-width:1100px;margin:0 auto;padding:28px}
            .nav{display:flex;align-items:center;justify-content:space-between;padding:12px 0}
            .brand{display:flex;align-items:center;gap:12px}
            .logo{width:48px;height:48px;border-radius:6px;background:linear-gradient(135deg,#ef4444,#f97316);display:flex;align-items:center;justify-content:center;color:white;font-weight:700}
            .hero{display:flex;gap:32px;align-items:center;padding:48px;background:linear-gradient(180deg,rgba(37,99,235,0.06),transparent);border-radius:12px}
            .hero-left{flex:1}
            .title{font-size:34px;margin:0 0 8px;color:#0f172a}
            .lead{color:var(--muted);margin:0 0 18px}
            .btn{display:inline-block;padding:10px 16px;border-radius:8px;font-weight:600}
            .btn-primary{background:var(--accent);color:#fff}
            .btn-outline{border:1px solid #e5e7eb;color:#0f172a;background:#fff}
            .features{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px;margin-top:22px}
            .card{background:#fff;padding:18px;border-radius:10px;box-shadow:0 6px 18px rgba(15,23,42,0.04)}
            .muted{color:var(--muted)}
            footer{margin-top:26px;color:var(--muted);font-size:13px}
            @media(max-width:760px){.hero{flex-direction:column;text-align:center}.hero-left{width:100%}}
        </style>
    </head>
    <body class="antialiased">
        <div class="container">
            <nav class="nav">
                <div class="brand">
                    <div class="logo">LM</div>
                    <div>
                        <div style="font-weight:700">Library Management</div>
                        <div class="muted" style="font-size:12px">Organize loans, books & users</div>
                    </div>
                </div>

                <div>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/home') }}" class="muted">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="muted">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" style="margin-left:12px">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </nav>

            <main class="hero">
                <div class="hero-left">
                    <h1 class="title">A simple library system for schools and communities</h1>
                    <p class="lead">Search the catalog, manage loans and keep user accounts in one lightweight app.</p>

                    <p>
                        <a href="{{ url('/books') }}" class="btn btn-primary">Browse Books</a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/home') }}" class="btn btn-outline" style="margin-left:10px">Go to Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline" style="margin-left:10px">Get Started</a>
                            @endauth
                        @endif
                    </p>

                    <div class="features">
                        <div class="card">
                            <strong>Search Catalog</strong>
                            <div class="muted" style="margin-top:6px">Find books by title, author or ISBN quickly.</div>
                        </div>

                        <div class="card">
                            <strong>Manage Loans</strong>
                            <div class="muted" style="margin-top:6px">Issue, return and track due dates with ease.</div>
                        </div>

                        <div class="card">
                            <strong>User Accounts</strong>
                            <div class="muted" style="margin-top:6px">Keep member records and borrowing history organized.</div>
                        </div>

                        <div class="card">
                            <strong>Reports</strong>
                            <div class="muted" style="margin-top:6px">Quick overviews of popular books and overdue items.</div>
                        </div>
                    </div>
                </div>

                <div style="width:360px;flex-shrink:0">
                    <div class="card">
                        <h3 style="margin:0 0 8px">Quick Stats</h3>
                        <div class="muted">Books: <strong>—</strong></div>
                        <div class="muted" style="margin-top:6px">Loans active: <strong>—</strong></div>
                        <div class="muted" style="margin-top:6px">Members: <strong>—</strong></div>

                        <div style="margin-top:16px">
                            <a href="{{ url('/books') }}" class="btn btn-primary" style="width:100%">View Catalog</a>
                        </div>
                    </div>
                </div>
            </main>

            <footer>
                <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
                    <div class="muted">Built with Laravel v{{ Illuminate\Foundation\Application::VERSION }}</div>
                    <div class="muted">PHP v{{ PHP_VERSION }}</div>
                </div>
            </footer>
        </div>
    </body>
</html>
