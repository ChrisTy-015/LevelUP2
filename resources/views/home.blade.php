<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LevelUp - Apprendre, Partager, Progresser</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.6/lottie.min.js"></script>
    <style>
        /* Styles généraux */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #1E3A8A;
            color: #fff;
        }

        header h1 {
            font-size: 2rem;
            font-weight: bold;
        }

        header nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        header nav a:hover {
            color: #93C5FD;
        }

        /* Section principale */
        .hero {
            text-align: center;
            padding: 50px 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .hero h2 {
            font-size: 2.5rem;
            color: #1E3A8A;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #555;
        }

        .hero .slogan {
            font-size: 1.5rem;
            margin: 20px 0;
            color: #1E3A8A;
            font-style: italic;
            font-weight: bold;
        }

        .hero .buttons {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }

        .hero .buttons a {
            text-decoration: none;
            padding: 15px 30px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 30px;
            transition: transform 0.2s ease, background-color 0.3s ease;
        }

        .hero .btn-signup {
            background-color: #2563EB; /* Bleu primaire */
            color: #fff;
        }

        .hero .btn-login {
            background-color: #93C5FD; /* Bleu clair */
            color: #1E3A8A;
        }

        .hero .buttons a:hover {
            transform: scale(1.1);
        }

        /* Stickers animés */
        .stickers {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }

        .sticker {
            position: absolute;
            width: 50px;
            height: 50px;
            animation: float 6s infinite ease-in-out;
        }

        .sticker:nth-child(1) { left: 10%; top: 10%; animation-delay: 0s; }
        .sticker:nth-child(2) { left: 30%; top: 60%; animation-delay: 2s; }
        .sticker:nth-child(3) { left: 50%; top: 25%; animation-delay: 4s; }
        .sticker:nth-child(4) { left: 75%; top: 75%; animation-delay: 1s; }
        .sticker:nth-child(5) { left: 90%; top: 15%; animation-delay: 3s; }
        .sticker:nth-child(6) { left: 20%; top: 85%; animation-delay: 2s; }
        .sticker:nth-child(7) { left: 50%; top: 90%; animation-delay: 1.5s; }
        .sticker:nth-child(8) { left: 80%; top: 40%; animation-delay: 0.5s; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 15px;
            background-color: #1E3A8A;
            color: #fff;
            font-size: 0.9rem;
            margin-top: auto;
        }

        footer a {
            color: #93C5FD;
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h2 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .hero .buttons a {
                padding: 10px 20px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>LevelUp</h1>
        <nav>
            <a href="#features">Fonctionnalités</a>
            <a href="#about">À propos</a>
            <a href="#contact">Contact</a>
        </nav>
    </header>

    <!-- Section principale -->
    <div class="hero">
        <h2>Apprends et partage tes compétences avec LevelUp</h2>
        <p>Connecte-toi avec des étudiants pour un mentorat bidirectionnel et fais évoluer tes compétences.</p>
        <p class="slogan">Apprendre, Partager, Progresser 🚀</p>
        <div class="buttons">
            <a href="/register" class="btn-signup">S'inscrire</a>
            <a href="/login" class="btn-login">Se connecter</a>
        </div>
    </div>

    <!-- Stickers animés -->
    <div class="stickers">
        <div id="lottie-rocket" class="sticker"></div>
        <img src="https://em-content.zobj.net/thumbs/240/apple/354/star_2b50.png" alt="star" class="sticker">
        <img src="https://em-content.zobj.net/thumbs/240/apple/354/light-bulb_1f4a1.png" alt="bulb" class="sticker">
        <img src="https://em-content.zobj.net/thumbs/240/apple/354/check-mark-button_2705.png" alt="check" class="sticker">
        <img src="https://em-content.zobj.net/thumbs/240/apple/354/sparkles_2728.png" alt="sparkles" class="sticker">
    </div>

    <!-- Footer -->
    <footer>
        <p>© 2025 LevelUp. Créé avec ❤️ pour les étudiants. <a href="#contact">Nous contacter</a></p>
    </footer>

    <!-- Script Lottie -->
    <script>
        var animation = lottie.loadAnimation({
            container: document.getElementById('lottie-rocket'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://assets10.lottiefiles.com/packages/lf20_jcikwtux.json'
        });
    </script>
</body>
</html>
