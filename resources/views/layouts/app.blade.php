<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Plateforme Électorale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            transition: background-color 0.3s, color 0.3s;
            line-height: 1.6;
        }
        .dark-mode {
            background-color: #15202b;
            color: #e7e9ea;
        }
        .light-mode {
            background-color: #f5f8fa;
            color: #0f1419;
        }
        .sidebar {
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            padding: 20px;
            transition: background-color 0.3s, border-color 0.3s;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        .dark-mode .sidebar { background-color: #15202b; }
        .light-mode .sidebar { background-color: #fff; }
        .sidebar a, .sidebar button {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            text-decoration: none;
            border-radius: 25px;
            margin-bottom: 10px;
            font-size: 16px;
            transition: background-color 0.2s;
        }
        .dark-mode .sidebar a, .dark-mode .sidebar button { color: #e7e9ea; }
        .light-mode .sidebar a, .light-mode .sidebar button { color: #0f1419; }
        .sidebar a:hover, .sidebar button:hover {
            background-color: rgba(29, 161, 242, 0.1);
            color: #1da1f2;
        }
        .content {
            margin-left: 280px;
            max-width: 700px;
            padding: 20px;
        }
        .dark-mode .card {
            background-color: #192734;
            border: none;
            color: #e7e9ea;
            border-radius: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .light-mode .card {
            background-color: #fff;
            border: 1px solid #e6ecf0;
            color: #0f1419;
            border-radius: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        .btn-primary {
            background-color: #1da1f2;
            border-color: #1da1f2;
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        .btn-primary:hover {
            background-color: #1a91da;
            border-color: #1a91da;
        }
        .dark-mode .list-group-item {
            background-color: #192734;
            color: #e7e9ea;
            border-color: #38444d;
            border-radius: 10px;
        }
        .light-mode .list-group-item {
            background-color: #fff;
            color: #0f1419;
            border-color: #e6ecf0;
            border-radius: 10px;
        }
        .dark-mode .text-muted { color: #8899a6 !important; }
        .light-mode .text-muted { color: #657786 !important; }
        .dark-mode .alert-success { background-color: #1c2526; border-color: #00d4b3; color: #00d4b3; }
        .light-mode .alert-success { background-color: #e6f7f3; border-color: #00c4b4; color: #00c4b4; }
        .dark-mode .alert-danger { background-color: #2d2026; border-color: #ff4d4f; color: #ff4d4f; }
        .light-mode .alert-danger { background-color: #fceaea; border-color: #ff4d4f; color: #ff4d4f; }
        .dark-mode .form-control {
            background-color: #253341;
            border-color: #38444d;
            color: #e7e9ea;
            border-radius: 10px;
        }
        .light-mode .form-control {
            background-color: #fff;
            border-color: #ccd6dd;
            color: #0f1419;
            border-radius: 10px;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                border-right: none;
                border-bottom: 1px solid #38444d;
            }
            .content { margin-left: 0; }
        }
        .nav-icon { font-size: 24px; margin-right: 15px; }
        .profile-img { border: 2px solid #1da1f2; }
    </style>
</head>
<body class="{{ session('theme', 'dark') }}-mode">
    <nav class="navbar navbar-dark d-lg-none" style="background-color: {{ session('theme', 'dark') == 'dark' ? '#15202b' : '#fff' }};">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="sidebar collapse d-lg-block" id="sidebarCollapse">
        <a href="{{ route('dashboard') }}" class="fw-bold">
            <i class="bi bi-twitter nav-icon"></i> Élections
        </a>
        <div class="mt-3 mb-3">
            <form action="{{ route('elections.search') }}" method="GET">
                <input type="text" name="query" class="form-control" placeholder="Rechercher une élection">
            </form>
        </div>
        <a href="{{ route('dashboard') }}">
            <i class="bi bi-house-door nav-icon"></i> Tableau de Bord
        </a>
        <a href="{{ route('elections.index') }}">
            <i class="bi bi-list-ul nav-icon"></i> Voir les élections
        </a>
        @auth
            @if (auth()->user()->role === 'ADMIN')
                <a href="{{ route('elections.create') }}">
                    <i class="bi bi-plus-square nav-icon"></i> Créer une élection
                </a>
                @php $firstElection = \App\Models\Election::first(); @endphp
                @if ($firstElection)
                    <a href="{{ route('candidats.create', $firstElection->id_election) }}">
                        <i class="bi bi-person-plus nav-icon"></i> Créer un candidat
                    </a>
                @endif
            @endif
            @php $firstElection = \App\Models\Election::first(); @endphp
            @if ($firstElection)
                <a href="{{ route('votes.create', $firstElection->id_election) }}">
                    <i class="bi bi-check2-square nav-icon"></i> Voter
                </a>
            @endif
            <a href="#" onclick="toggleTheme()" class="theme-toggle">
                <i class="bi bi-moon-stars-fill nav-icon"></i> Mode {{ session('theme', 'dark') == 'dark' ? 'Clair' : 'Sombre' }}
            </a>
            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-link text-decoration-none w-100 text-start ps-3" style="color: {{ session('theme', 'dark') == 'dark' ? '#e7e9ea' : '#0f1419' }};">
                    <i class="bi bi-box-arrow-right nav-icon"></i> Déconnexion
                </button>
            </form>
        @else
            <a href="{{ route('login') }}">
                <i class="bi bi-box-arrow-in-right nav-icon"></i> Connexion
            </a>
            <a href="{{ route('register') }}">
                <i class="bi bi-person-plus nav-icon"></i> Inscription
            </a>
        @endauth
    </div>

    <div class="content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function toggleTheme() {
            const currentTheme = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.body.classList.remove(currentTheme + '-mode');
            document.body.classList.add(newTheme + '-mode');
            fetch('/toggle-theme', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ theme: newTheme })
            });
        }
    </script>
</body>
</html>
