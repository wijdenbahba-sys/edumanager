<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🎓</text></svg>">
        <title>EduManager - @yield('title', 'Plateforme Scolaire')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">

    @php
        $unreadMessages = \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
        $unreadNotifications = Auth::user()->unreadNotifications->count();
    @endphp

    <!-- Sidebar (Menu de gauche) - Dégradé Moderne -->
    <aside class="fixed top-0 left-0 w-64 h-screen bg-gradient-to-b from-slate-900 to-slate-800 text-slate-300 z-50 flex flex-col shadow-2xl">
        
        <!-- Logo -->
        <div class="flex items-center gap-3 px-6 py-6 border-b border-white/10">
            <span class="text-3xl">🎓</span>
            <h2 class="text-2xl font-bold text-white tracking-wide">EduManager</h2>
        </div>
        
        <!-- Menu mte3 el Sidebar -->
        <nav class="flex flex-col gap-1 flex-1 px-4 py-4 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10 transition duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white font-semibold shadow-inner' : '' }}">
                <span class="text-xl">📊</span> Tableau de bord
            </a>
            
            <!-- Bouton Profil (Yban l kol les rôles) -->
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10 transition duration-200 {{ request()->routeIs('profile.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
                <span class="text-xl">👤</span> Mon Profil
            </a>

            @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('teachers.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10 transition duration-200 {{ request()->routeIs('teachers.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
                    <span class="text-xl">👨‍🏫</span> Enseignants
                </a>
                <a href="{{ route('classes.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10 transition duration-200 {{ request()->routeIs('classes.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
                    <span class="text-xl">🏫</span> Classes
                </a>
                <a href="{{ route('payments.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10 transition duration-200 {{ request()->routeIs('payments.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
                    <span class="text-xl">💰</span> Paiements
                </a>
            @endif

            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('teacher'))
                <a href="{{ route('students.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10 transition duration-200 {{ request()->routeIs('students.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
                    <span class="text-xl">👨‍🎓</span> Étudiants
                </a>
                <a href="{{ route('absences.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10 transition duration-200 {{ request()->routeIs('absences.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
                    <span class="text-xl">📅</span> Absences
                </a>
            @endif

            @if(Auth::user()->hasRole('student'))
                <a href="{{ route('students.myProfile') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10 transition duration-200 {{ request()->routeIs('students.myProfile') ? 'bg-white/20 text-white font-semibold' : '' }}">
                    <span class="text-xl">📊</span> Mon Espace (Notes)
                </a>
            @endif
            
            <a href="{{ route('documents.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10 transition duration-200 {{ request()->routeIs('documents.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
                <span class="text-xl">📚</span> Support de Cours
            </a>
            <a href="{{ route('schedules.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10 transition duration-200 {{ request()->routeIs('schedules.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
                <span class="text-xl">📅</span> Emploi du Temps
            </a>

            <!-- Notifications w Messagerie (direct ta7t Emploi du Temps) -->
            <hr class="border-white/10 my-2">
            
            <a href="{{ route('notifications.index') }}" class="flex items-center justify-between px-3 py-2 rounded-xl hover:bg-white/10 transition text-slate-300">
                <div class="flex items-center gap-3">
                    <span class="text-xl">🔔</span> Notifications
                </div>
                @if($unreadNotifications > 0)
                    <span style="background-color: #ef4444; color: white; font-size: 12px; font-weight: bold; border-radius: 50%; height: 20px; width: 20px; display: flex; align-items: center; justify-content: center;">
                        {{ $unreadNotifications }}
                    </span>
                @endif
            </a>
            
            <a href="{{ route('messages.index') }}" class="flex items-center justify-between px-3 py-2 rounded-xl hover:bg-white/10 transition text-slate-300">
                <div class="flex items-center gap-3">
                    <span class="text-xl">💬</span> Messagerie
                </div>
                @if($unreadMessages > 0)
                    <span style="background-color: #ef4444; color: white; font-size: 12px; font-weight: bold; border-radius: 50%; height: 20px; width: 20px; display: flex; align-items: center; justify-content: center;">
                        {{ $unreadMessages }}
                    </span>
                @endif
            </a>
        </nav>
    </aside>

    <!-- Contenu principal (à droite) -->
    <div class="ml-64 min-h-screen flex flex-col">
        
        <!-- Topbar (Glass Effect) -->
                <!-- Topbar (Glass Effect) -->
        <header class="bg-white/80 backdrop-blur-md border-b border-gray-200 px-8 py-4 flex justify-between items-center sticky top-0 z-40">
            
            <!-- Lwes: Titre w Search -->
            <div class="flex items-center gap-6">
                <h1 class="text-2xl font-bold text-slate-800 whitespace-nowrap">@yield('title', 'Dashboard')</h1>
                
                
                 <!-- Search Bar (b style direct bch ma ykrahch) -->
                <form action="{{ route('search') }}" method="GET" style="position: relative; display: flex; align-items: center;">
                    <input type="text" name="q" placeholder="Rechercher..." style="width: 250px; padding: 8px 10px 8px 35px; border-radius: 20px; border: 1px solid #e5e7eb; outline: none; font-size: 14px;" required>
                    <svg style="position: absolute; left: 10px; width: 18px; height: 18px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </form>
            </div>

            <!-- Rwes: Profil w Logout -->
            <div class="flex items-center gap-6">
                <span class="bg-brand-100 text-brand-700 font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wider">
                    {{ Auth::user()->getRoleNames()->first() ?? 'Utilisateur' }}
                </span>
                <div class="flex items-center gap-3">
                    <span class="font-semibold text-slate-700">{{ Auth::user()->name }}</span>
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover shadow-lg">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-500 to-brand-700 text-white flex items-center justify-center font-bold text-lg shadow-lg">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold transition-colors">Déconnexion</button>
                </form>
            </div>
        </header>
        <!-- Contenu -->
        <main class="p-8 flex-1">
            @yield('content')
        </main>
    </div>

</body>
</html>