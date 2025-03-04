<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Plateforme Électorale</title>

    <!-- Bootstrap et Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Styles personnalisés -->
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            transition: background-color 0.3s, color 0.3s;
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .dark-mode {
            background-color: #15202b;
            color: #e7e9ea;
        }
        .light-mode {
            background-color: #f5f8fa;
            color: #0f1419;
        }
        .card {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            border-radius: 15px;
        }
        .dark-mode .card {
            background-color: #192734;
            border: none;
            color: #e7e9ea;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .light-mode .card {
            background-color: #fff;
            border: 1px solid #e6ecf0;
            color: #0f1419;
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
        .dark-mode .text-muted { color: #8899a6 !important; }
        .light-mode .text-muted { color: #657786 !important; }
        .form-check-label { font-size: 0.9rem; }
    </style>
</head>
<body class="{{ session('theme', 'dark') }}-mode">
    <div class="card p-3">
        <h2 class="mb-4 text-center"><i class="bi bi-box-arrow-in-right"></i> Connexion</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                <label class="form-check-label" for="remember">Se souvenir de moi</label>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Se connecter</button>
                <a href="{{ route('register') }}" class="btn btn-outline-light">S'inscrire</a>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
