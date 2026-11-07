<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EduManager - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: #f3f4f6; font-family: sans-serif; margin: 0; padding: 0;">

    <!-- Sidebar (Menu de gauche) -->
    <aside style="position: fixed; top: 0; left: 0; width: 250px; height: 100vh; background-color: #111827; color: white; z-index: 50; padding: 20px; box-sizing: border-box;">
        <h2 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 30px;">🎓 EduManager</h2>
        
        <nav style="display: flex; flex-direction: column; gap: 10px;">
            <a href="{{ route('dashboard') }}" style="color: #d1d5db; text-decoration: none; padding: 10px; border-radius: 5px; display: block;">📊 Tableau de bord</a>
            <a href="{{ route('students.index') }}" style="color: #d1d5db; text-decoration: none; padding: 10px; border-radius: 5px; display: block;">👨‍🎓 Étudiants</a>
            <a href="{{ route('teachers.index') }}" style="color: #d1d5db; text-decoration: none; padding: 10px; border-radius: 5px; display: block;">👨‍🏫 Enseignants</a>
            <a href="{{ route('courses.index') }}" style="color: #d1d5db; text-decoration: none; padding: 10px; border-radius: 5px; display: block;">📚 Cours & Notes</a>
        </nav>
    </aside>

    <!-- Contenu principal (à droite) -->
    <div style="margin-left: 250px; padding: 20px;">
        
        <!-- Topbar -->
        <div style="background-color: white; padding: 15px 20px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px;">
            <h1 style="font-size: 1.5rem; font-weight: bold; color: #1f2937; margin: 0;">@yield('title', 'Dashboard')</h1>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span style="font-weight: 500; color: #4b5563;">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer; font-weight: bold; padding: 0;">Déconnexion</button>
                </form>
            </div>
        </div>

        <!-- Zone où le contenu des pages va s'afficher -->
        <div>
            @yield('content')
        </div>
    </div>

</body>
</html>