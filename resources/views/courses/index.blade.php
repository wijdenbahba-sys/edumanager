@extends('layouts.admin')

@section('title', 'Gestion des Cours')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">📚 Gestion des Cours</h1>
        <a href="{{ route('courses.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
            + Ajouter un cours
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-4">Nom du cours</th>
                    <th class="py-3 px-4">Enseignant</th>
                    <th class="py-3 px-4">Classe</th>
                    <th class="py-3 px-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($courses as $course)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-4 font-medium">{{ $course->nom }}</td>
                        <td class="py-3 px-4">{{ $course->teacher->user->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4">
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-bold">{{ $course->classRoom->nom ?? 'N/A' }}</span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-bold">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">Aucun cours enregistré.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection