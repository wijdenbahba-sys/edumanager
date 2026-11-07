@extends('layouts.admin')

@section('title', 'Liste des Étudiants')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        
        <!-- En-tête avec le bouton Ajouter -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-800">Tous les étudiants</h2>
            <a href="{{ route('students.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Ajouter un étudiant
            </a>
        </div>

        <!-- Barre de recherche et Filtre -->
        <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
            <form action="{{ route('students.index') }}" method="GET" class="flex items-end gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rechercher par nom ou email</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ex: Étudiant 1..." class="w-full border rounded px-3 py-2">
                </div>
                <div class="w-64">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filtrer par classe</label>
                    <select name="class_id" class="w-full border rounded px-3 py-2">
                        <option value="">Toutes les classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-6 rounded h-10">
                    Filtrer
                </button>
                @if(request()->has('search') || request()->has('class_id'))
                    <a href="{{ route('students.index') }}" class="text-red-500 hover:underline py-2 pb-3">Réinitialiser</a>
                @endif
            </form>
        </div>

        <!-- Message de succès -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tableau -->
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6">Nom</th>
                    <th class="py-3 px-6">Email</th>
                    <th class="py-3 px-6">Classe</th>
                    <th class="py-3 px-6">Date de naissance</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($students as $student)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6 font-medium">{{ $student->user->name }}</td>
                    <td class="py-3 px-6">{{ $student->user->email }}</td>
                    <td class="py-3 px-6">
                        <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs">
                            {{ $student->classRoom ? $student->classRoom->nom : 'Aucune' }}
                        </span>
                    </td>
                    <td class="py-3 px-6">{{ $student->date_naissance }}</td>
                    
                    <td class="py-3 px-6 text-center">
                        <div class="flex items-center justify-center gap-4">
                            <a href="{{ route('students.show', $student->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Voir</a>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Supprimer cet étudiant ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-500">
                        Aucun étudiant trouvé pour cette recherche.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>
@endsection