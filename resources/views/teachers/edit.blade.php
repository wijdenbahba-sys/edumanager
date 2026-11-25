@extends('layouts.admin')

@section('title', 'Modifier un Enseignant')

@section('content')
    <div class="mb-4">
        <a href="{{ route('teachers.index') }}" class="text-blue-600 hover:underline">← Retour à la liste</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-lg mx-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Modifier l'Enseignant</h2>
        
        <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nom complet</label>
                <input type="text" name="name" value="{{ $teacher->user->name }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ $teacher->user->email }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Matière principale</label>
                <input type="text" name="matiere_principale" value="{{ $teacher->matiere_principale }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Mettre à jour
            </button>
            <a href="{{ route('teachers.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
        </form>
    </div>
@endsection