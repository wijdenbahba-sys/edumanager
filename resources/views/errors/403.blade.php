<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accès non autorisé</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding-top: 100px; background-color: #f3f4f6; }
        h1 { font-size: 80px; color: #ef4444; margin: 0; }
        p { font-size: 20px; color: #4b5563; }
        a { display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #3b82f6; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>403</h1>
    <p>Désolé, vous n'avez pas l'autorisation d'accéder à cette page.</p>
    <a href="{{ url('/dashboard') }}">Retour au tableau de bord</a>
</body>
</html>