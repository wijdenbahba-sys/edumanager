<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - EduManager</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap');
        body { 
            margin: 0; 
            font-family: 'Inter', sans-serif; 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            padding: 20px;
            box-sizing: border-box;
        }
        .glass-card { 
            background: rgba(255, 255, 255, 0.95); 
            padding: 40px 50px; 
            border-radius: 20px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.2); 
            width: 100%; 
            max-width: 450px; 
            text-align: center; 
        }
        .glass-card h2 { color: #333; margin: 0 0 10px 0; font-size: 32px; font-weight: 800; }
        .glass-card p { color: #666; margin-bottom: 30px; font-size: 15px; }
        .form-group { text-align: left; margin-bottom: 15px; }
        .form-group label { display: block; color: #444; font-weight: 600; margin-bottom: 6px; font-size: 14px; }
        .form-group input { 
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; 
            font-size: 15px; box-sizing: border-box; transition: all 0.3s; background: #f9f9f9; 
        }
        .form-group input:focus { border-color: #667eea; outline: none; background: #fff; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2); }
        
        .radio-group { display: flex; gap: 20px; margin-top: 10px; }
        .radio-label { display: flex; align-items: center; cursor: pointer; font-weight: 600; color: #444; font-size: 14px; }
        .radio-label input { margin-right: 8px; transform: scale(1.2); }

        .btn-register { 
            width: 100%; padding: 14px; border: none; border-radius: 10px; 
            background: linear-gradient(90deg, #667eea, #764ba2); color: white; 
            font-size: 16px; font-weight: 700; cursor: pointer; transition: transform 0.2s; margin-top: 15px; 
        }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(118, 75, 162, 0.4); }
        .footer { margin-top: 20px; font-size: 14px; color: #666; }
        .footer a { color: #667eea; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="glass-card">
        <h2>Créer un compte</h2>
        <p>Rejoignez la plateforme EduManager</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label>Nom complet</label>
                <input type="text" name="name" placeholder="Ex: Etudiant Ali" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Votre adresse email" required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <div class="form-group">
                <label>Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" required>
            </div>

            <div class="form-group">
                <label>Je suis :</label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="role" value="student" required checked>
                        🎓 Étudiant
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="role" value="teacher" required>
                        👨‍🏫 Enseignant
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-register">S'inscrire</button>
        </form>

        <div class="footer">
            Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
        </div>
    </div>
</body>
</html>