<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduManager - La gestion scolaire réinventée</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🎓</text></svg>">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        
        body {
            background-color: #0f172a;
            color: white;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .logo { font-size: 24px; font-weight: 800; color: #38bdf8; display: flex; align-items: center; gap: 10px;}
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { color: #cbd5e1; text-decoration: none; font-weight: 600; transition: color 0.3s; }
        .nav-links a:hover { color: #38bdf8; }
        .btn-nav { background: linear-gradient(90deg, #3b82f6, #8b5cf6); padding: 10px 24px; border-radius: 8px; color: white !important; transition: transform 0.2s; }
        .btn-nav:hover { transform: scale(1.05); }

        /* Hero Section */
        .hero {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: radial-gradient(circle at top, #1e1b4b 0%, #0f172a 100%);
            padding: 0 20px;
        }
        .hero h1 { font-size: 64px; font-weight: 800; line-height: 1.1; margin-bottom: 20px; max-width: 900px; color: #f8fafc; }
        .hero h1 span { background: linear-gradient(90deg, #38bdf8, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero p { font-size: 20px; color: #94a3b8; max-width: 600px; margin-bottom: 40px; line-height: 1.6; }
        
        /* Buttons */
        .hero-btns { display: flex; gap: 20px; }
        .btn-primary { 
            background: linear-gradient(90deg, #3b82f6, #8b5cf6); color: white; padding: 15px 40px; 
            border-radius: 10px; text-decoration: none; font-weight: bold; font-size: 18px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(139, 92, 246, 0.3); }
        
        .btn-secondary { 
            background: transparent; color: #cbd5e1; padding: 15px 40px; border-radius: 10px; 
            text-decoration: none; font-weight: bold; font-size: 18px; border: 1px solid #475569;
            transition: background 0.3s;
        }
        .btn-secondary:hover { background: #1e293b; }

        /* Features Section */
        .features {
            padding: 100px 50px;
            background: #0f172a;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            background: rgba(30, 41, 59, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 40px;
            border-radius: 20px;
            transition: transform 0.3s, border-color 0.3s;
            backdrop-filter: blur(5px);
        }
        .card:hover { transform: translateY(-10px); border-color: #38bdf8; }
        .icon { font-size: 40px; margin-bottom: 20px; }
        .card h3 { font-size: 22px; margin-bottom: 15px; color: #f8fafc; }
        .card p { color: #94a3b8; line-height: 1.6; }
        
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">🎓 EduManager</div>
        <div class="nav-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-nav">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}">Se connecter</a>
                    <a href="{{ route('register') }}" class="btn-nav">S'inscrire</a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <h1>La gestion scolaire <br> <span>réinventée.</span></h1>
        <p>Une plateforme puissante, sécurisée et intuitive pour connecter les administrateurs, les enseignants et les étudiants.</p>
        <div class="hero-btns">
            <a href="{{ route('login') }}" class="btn-primary">Commencer maintenant</a>
            <a href="#features" class="btn-secondary">En savoir plus ↓</a>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="card">
            <div class="icon">📊</div>
            <h3>Statistiques en temps réel</h3>
            <p>Suivez les moyennes, les absences et les performances de chaque étudiant avec des graphiques interactifs.</p>
        </div>
        <div class="card">
            <div class="icon">📝</div>
            <h3>Gestion des Notes</h3>
            <p>Ajoutez des notes, générez des bulletins PDF professionnels et calculez les moyennes automatiquement.</p>
        </div>
        <div class="card">
            <div class="icon">🔐</div>
            <h3>Sécurité par Rôle</h3>
            <p>Chaque utilisateur (Admin, Enseignant, Étudiant) a accès uniquement aux données qui le concernent.</p>
        </div>
    </section>
    <!-- Section Statistiques -->
    <section style="padding: 80px 20px; background: #0f172a; text-align: center;">
        <div style="max-width: 1000px; margin: 0 auto;">
            <h2 style="font-size: 36px; font-weight: 800; color: #f8fafc; margin-bottom: 40px;">Rejoignez une communauté en pleine croissance</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px;">
                <div style="background: rgba(30, 41, 59, 0.4); padding: 30px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.05);">
                    <div style="font-size: 48px; font-weight: 800; color: #38bdf8; margin-bottom: 10px;">50+</div>
                    <div style="color: #94a3b8; font-size: 18px; font-weight: 600;">Étudiants</div>
                </div>
                <div style="background: rgba(30, 41, 59, 0.4); padding: 30px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.05);">
                    <div style="font-size: 48px; font-weight: 800; color: #818cf8; margin-bottom: 10px;">15+</div>
                    <div style="color: #94a3b8; font-size: 18px; font-weight: 600;">Enseignants</div>
                </div>
                <div style="background: rgba(30, 41, 59, 0.4); padding: 30px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.05);">
                    <div style="font-size: 48px; font-weight: 800; color: #c084fc; margin-bottom: 10px;">20+</div>
                    <div style="color: #94a3b8; font-size: 18px; font-weight: 600;">Cours Actifs</div>
                </div>
            </div>
        </div>
    </section>
</body>
    <!-- Footer -->
    <footer style="background: #020617; padding: 40px 20px; border-top: 1px solid rgba(255,255,255,0.05); text-align: center;">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; flex-direction: column; align-items: center; gap: 20px;">
            <div style="font-size: 24px; font-weight: 800; color: #38bdf8;">🎓 EduManager</div>
            
            <div style="display: flex; gap: 30px;">
                <a href="{{ route('login') }}" style="color: #94a3b8; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='#38bdf8'" onmouseout="this.style.color='#94a3b8'">Connexion</a>
                <a href="{{ route('register') }}" style="color: #94a3b8; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='#38bdf8'" onmouseout="this.style.color='#94a3b8'">Inscription</a>
                <a href="#features" style="color: #94a3b8; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='#38bdf8'" onmouseout="this.style.color='#94a3b8'">Fonctionnalités</a>
            </div>
            
                        <div style="color: #64748b; font-size: 14px; display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 5px;">
                    Fait avec <span style="color: #ef4444; font-size: 16px;">❤️</span> par 
                    <span style="color: #38bdf8; font-weight: 600;">Wijden Bahba</span>
                </div>
                <div>© {{ date('Y') }} EduManager. Tous droits réservés.</div>
            </div>
        </div>
    </footer>
</html>