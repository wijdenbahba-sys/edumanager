<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - EduManager</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap');
        body { margin: 0; font-family: 'Inter', sans-serif; height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .glass-card { background: rgba(255, 255, 255, 0.95); padding: 50px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); width: 100%; max-width: 400px; text-align: center; }
        .glass-card h2 { color: #333; margin: 0 0 10px 0; font-size: 32px; font-weight: 800; }
        .glass-card p { color: #666; margin-bottom: 30px; }
        .form-group { text-align: left; margin-bottom: 20px; }
        .form-group label { display: block; color: #444; font-weight: 600; margin-bottom: 8px; font-size: 14px; }
        .form-group input { width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 10px; font-size: 16px; box-sizing: border-box; transition: all 0.3s; background: #f9f9f9; }
        .form-group input:focus { border-color: #667eea; outline: none; background: #fff; box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2); }
        .btn-login { width: 100%; padding: 15px; border: none; border-radius: 10px; background: linear-gradient(90deg, #667eea, #764ba2); color: white; font-size: 18px; font-weight: 700; cursor: pointer; transition: transform 0.2s; margin-top: 10px; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(118, 75, 162, 0.4); }
        .footer { margin-top: 20px; font-size: 14px; color: #666; }
        .footer a { color: #667eea; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="glass-card">
        <h2>Bienvenue ! 👋</h2>
        <p>Connectez-vous à votre espace EduManager</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Votre adresse email" required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="Votre mot de passe" required>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; font-size: 14px;">
                <label style="display: flex; align-items: center; color: #666; cursor: pointer;">
                    <input type="checkbox" name="remember" style="margin-right: 8px;"> Se souvenir
                </label>
                <a href="{{ route('password.request') }}" style="color: #667eea; text-decoration: none;">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="btn-login">Se connecter</button>
        </form>

        <div class="footer">
            Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a>
        </div>
    </div>
</body>
</html>