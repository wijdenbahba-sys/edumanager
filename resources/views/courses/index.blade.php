@extends('layouts.admin')

@section('title', 'Gestion des Cours')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">Tous les cours</h2>
            <a href="{{ route('courses.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Ajouter un cours
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6">Nom du cours</th>
                    <th class="py-3 px-6">Enseignant</th>
                    <th class="py-3 px-6">Classe</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($courses as $course)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6 font-medium">{{ $course->nom }}</td>
                    <td class="py-3 px-6">{{ $course->teacher->user->name ?? 'Non assigné' }}</td>
                    <td class="py-3 px-6">
                        <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs">
                            {{ $course->classRoom->nom ?? 'Aucune' }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Supprimer ce cours ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-4">
            {{ $courses->links() }}
        </div>
    </div>
@endsection