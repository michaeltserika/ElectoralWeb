<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Plateforme Électorale</title>

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
        .form-control {
            border-radius: 10px;
        }
    </style>
</head>
<body class="{{ session('theme', 'dark') }}-mode">
    <div class="card p-3">
        <h2 class="mb-4 text-center"><i class="bi bi-person-plus"></i> Inscription</h2>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input id="nom" type="text" class="form-control" name="nom" value="{{ old('nom') }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>
            <div class="mb-3">
                <label for="ce_number" class="form-label">Numéro CE</label>
                <input id="ce_number" type="number" class="form-control" name="ce_number" value="{{ old('ce_number') }}">
            </div>
            <div class="mb-3">
                <label for="cin_number" class="form-label">Numéro CIN</label>
                <input id="cin_number" type="number" class="form-control" name="cin_number" value="{{ old('cin_number') }}">
            </div>
            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date de naissance</label>
                <input id="date_of_birth" type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Photo de profil</label>
                <input id="image" type="file" class="form-control" name="image" accept="image/*">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">S'inscrire</button>
                <a href="{{ route('login') }}" class="btn btn-outline-light">Se connecter</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
