<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plateforme Électorale Sociale</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Bootstrap et Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Animate.css pour animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Styles personnalisés -->
    <style>
        body {
            font-family: 'Instrument Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            transition: background-color 0.5s ease, color 0.5s ease;
            line-height: 1.6;
            overflow-x: hidden;
        }
        .dark-mode {
            background: linear-gradient(135deg, #15202b 0%, #1c2526 100%);
            color: #e7e9ea;
        }
        .light-mode {
            background: linear-gradient(135deg, #f5f8fa 0%, #e6ecf0 100%);
            color: #0f1419;
        }
        .content {
            max-width: 800px;
            padding: 40px 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin: 0 auto;
        }
        .dark-mode .card {
            background: rgba(25, 39, 52, 0.9);
            border: none;
            color: #e7e9ea;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }
        .light-mode .card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid #e6ecf0;
            color: #0f1419;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        .btn-primary {
            background: #1da1f2;
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-primary::after {
            content: '';
            position: absolute;
            top: 50%;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-50%);
            transition: all 0.4s ease;
        }
        .btn-primary:hover::after { left: 0; }
        .btn-primary:hover {
            background: #1a91da;
            transform: scale(1.05);
        }
        .dark-mode .text-muted { color: #8899a6 !important; }
        .light-mode .text-muted { color: #657786 !important; }
        .welcome-logo {
            max-width: 100%;
            height: auto;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));
            transition: transform 0.5s ease;
        }
        .welcome-logo.parallax {
            transform: translateY(var(--parallax-offset));
        }
        .counter {
            font-size: 2rem;
            font-weight: 700;
            color: #1da1f2;
            transition: all 1s ease;
        }
        .voting-animation {
            position: relative;
            height: 100px;
            overflow: hidden;
        }
        .voter {
            position: absolute;
            font-size: 2rem;
            animation: voteWalk 4s infinite linear;
        }
        .voter.boy { color: #1da1f2; animation-delay: 0s; }
        .voter.girl { color: #ff4d4f; animation-delay: 2s; }
        .cascade-word {
            display: inline-block;
            opacity: 0;
            animation: cascadeIn 0.5s ease-out forwards;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes voteWalk {
            0% { left: -50px; opacity: 0; }
            20% { opacity: 1; }
            80% { opacity: 1; }
            100% { left: 100%; opacity: 0; }
        }
        @keyframes cascadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 991.98px) {
            .content { padding: 20px; }
            .welcome-logo { width: 200px; }
            .counter { font-size: 1.5rem; }
        }
    </style>
</head>
<body class="{{ session('theme', 'dark') }}-mode">
    <!-- Contenu principal -->
    <div class="content">
        <div class="card p-4 mb-5 fade-in-up">
            <h1 class="mb-3 text-center" style="font-weight: 700; font-size: 2.5rem; color: {{ session('theme', 'dark') == 'dark' ? '#e7e9ea' : '#0f1419' }}">
                <span class="cascade-word" style="animation-delay: 0s;">Découvrez</span>
                <span class="cascade-word" style="animation-delay: 0.2s;">une</span>
                <span class="cascade-word" style="animation-delay: 0.4s;">nouvelle</span>
                <span class="cascade-word" style="animation-delay: 0.6s;">ère</span>
                <span class="cascade-word" style="animation-delay: 0.8s;">électorale</span>
            </h1>
            <p class="text-muted text-center mb-4" style="font-size: 1.2rem; color: {{ session('theme', 'dark') == 'dark' ? '#8899a6' : '#657786' }}">
                Engagez-vous, votez et interagissez dans une expérience sociale unique.
            </p>
            <div class="d-flex justify-content-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary animate__animated animate__pulse animate__infinite">
                        <i class="bi bi-house-door me-2"></i> Commencer
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary animate__animated animate__pulse animate__infinite">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Se connecter
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-light">
                            <i class="bi bi-person-plus me-2"></i> S'inscrire
                        </a>
                    @endif
                @endauth
                <button onclick="toggleTheme()" class="btn btn-outline-light">
                    <i class="bi bi-moon-stars-fill me-2"></i> Mode {{ session('theme', 'dark') == 'dark' ? 'Clair' : 'Sombre' }}
                </button>
            </div>
        </div>

        <!-- Compteurs animés -->
        <div class="d-flex justify-content-around mb-5 fade-in-up" style="animation-delay: 0.5s;">
            <div class="text-center">
                <div class="counter" data-target="{{ \App\Models\Election::count() }}">0</div>
                <p class="text-muted" style="color: {{ session('theme', 'dark') == 'dark' ? '#8899a6' : '#657786' }}">Élections</p>
            </div>
            <div class="text-center">
                <div class="counter" data-target="{{ \App\Models\Vote::count() }}">0</div>
                <p class="text-muted" style="color: {{ session('theme', 'dark') == 'dark' ? '#8899a6' : '#657786' }}">Votes</p>
            </div>
            <div class="text-center">
                <div class="counter" data-target="{{ \App\Models\Utilisateur::count() }}">0</div>
                <p class="text-muted" style="color: {{ session('theme', 'dark') == 'dark' ? '#8899a6' : '#657786' }}">Utilisateurs</p>
            </div>
        </div>

        <!-- Animation de vote -->
        <div class="voting-animation mb-5 fade-in-up" style="animation-delay: 1s;">
            <i class="bi bi-person-fill voter boy"></i>
            <i class="bi bi-person-fill voter girl"></i>
        </div>

        <!-- Logo avec parallaxe -->
        <div class="text-center zoom-in" style="animation-delay: 1.5s;">
            <svg class="welcome-logo parallax" width="350" height="120" viewBox="0 0 438 104" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.2036 -3H0V102.197H49.5189V86.7187H17.2036V-3Z" fill="#1da1f2" />
                <path d="M110.256 41.6337C108.061 38.1275 104.945 35.3731 100.905 33.3681C96.8667 31.3647 92.8016 30.3618 88.7131 30.3618C83.4247 30.3618 78.5885 31.3389 74.201 33.2923C69.8111 35.2456 66.0474 37.928 62.9059 41.3333C59.7643 44.7401 57.3198 48.6726 55.5754 53.1293C53.8287 57.589 52.9572 62.274 52.9572 67.1813C52.9572 72.1925 53.8287 76.8995 55.5754 81.3069C57.3191 85.7173 59.7636 89.6241 62.9059 93.0293C66.0474 96.4361 69.8119 99.1155 74.201 101.069C78.5885 103.022 83.4247 103.999 88.7131 103.999C92.8016 103.999 96.8667 102.997 100.905 100.994C104.945 98.9911 108.061 96.2359 110.256 92.7282V102.195H126.563V32.1642H110.256V41.6337ZM108.76 75.7472C107.762 78.4531 106.366 80.8078 104.572 82.8112C102.776 84.8161 100.606 86.4183 98.0637 87.6206C95.5202 88.823 92.7004 89.4238 89.6103 89.4238C86.5178 89.4238 83.7252 88.823 81.2324 87.6206C78.7388 86.4183 76.5949 84.8161 74.7998 82.8112C73.004 80.8078 71.6319 78.4531 70.6856 75.7472C69.7356 73.0421 69.2644 70.1868 69.2644 67.1821C69.2644 64.1758 69.7356 61.3205 70.6856 58.6154C71.6319 55.9102 73.004 53.5571 74.7998 51.5522C76.5949 49.5495 78.738 47.9451 81.2324 46.7427C83.7252 45.5404 86.5178 44.9396 89.6103 44.9396C92.7012 44.9396 95.5202 45.5404 98.0637 46.7427C100.606 47.9451 102.776 49.5487 104.572 51.5522C106.367 53.5571 107.762 55.9102 108.76 58.6154C109.756 61.3205 110.256 64.1758 110.256 67.1821C110.256 70.1868 109.756 73.0421 108.76 75.7472Z" fill="#1da1f2" />
            </svg>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

        // Animation au chargement
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.fade-in-up, .zoom-in');
            elements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.2}s`;
            });

            // Compteurs animés
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                let count = 0;
                const speed = 2000 / target;
                const updateCounter = () => {
                    const increment = target / 100;
                    if (count < target) {
                        count += increment;
                        counter.textContent = Math.ceil(count);
                        setTimeout(updateCounter, speed);
                    } else {
                        counter.textContent = target;
                    }
                };
                updateCounter();
            });
        });

        // Parallaxe pour le logo
        window.addEventListener('scroll', () => {
            const logo = document.querySelector('.welcome-logo.parallax');
            const scrollPosition = window.scrollY;
            logo.style.setProperty('--parallax-offset', `${scrollPosition * 0.3}px`);
        });
    </script>
</body>
</html>
