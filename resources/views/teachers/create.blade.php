@extends('layouts.admin')

@section('title', 'Ajouter un Enseignant')

@section('content')
    <div class="mb-4">
        <a href="{{ route('teachers.index') }}" class="text-blue-600 hover:underline">← Retour à la liste</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-lg mx-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Nouvel Enseignant</h2>
        
        <form action="{{ route('teachers.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nom complet</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Matière principale</label>
                <input type="text" name="matiere_principale" class="w-full border rounded px-3 py-2" required>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Enregistrer
            </button>
            <a href="{{ route('teachers.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
        </form>
    </div>
@endsection