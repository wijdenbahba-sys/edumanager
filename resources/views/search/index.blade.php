@extends('layouts.admin')

@section('title', 'Résultats de recherche')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Résultats pour : "{{ $query }}"</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Section Étudiants / Users -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">👤 Utilisateurs trouvés ({{ $users->count() }})</h2>
            <ul class="divide-y divide-gray-200">
                @forelse($users as $user)
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <p class="font-bold text-gray-800">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $user->email }} - <span class="font-bold text-brand-600">{{ $user->getRoleNames()->first() }}</span></p>
                        </div>
                        @if($user->hasRole('student'))
                            <a href="{{ route('students.show', $user->student->id ?? 0) }}" class="text-blue-600 hover:underline text-sm font-bold">Voir le profil</a>
                        @endif
                    </li>
                @empty
                    <li class="py-3 text-gray-500 text-center">Aucun utilisateur trouvé.</li>
                @endforelse
            </ul>
        </div>

        <!-- Section Cours -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">📚 Cours trouvés ({{ $courses->count() }})</h2>
            <ul class="divide-y divide-gray-200">
                @forelse($courses as $course)
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <p class="font-bold text-gray-800">{{ $course->nom }}</p>
                            <p class="text-sm text-gray-500">Prof: {{ $course->teacher->user->name ?? 'N/A' }} | Classe: {{ $course->classRoom->nom ?? 'N/A' }}</p>
                        </div>
                        <a href="{{ route('courses.show', $course->id) }}" class="text-blue-600 hover:underline text-sm font-bold">Voir le cours</a>
                    </li>
                @empty
                    <li class="py-3 text-gray-500 text-center">Aucun cours trouvé.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection