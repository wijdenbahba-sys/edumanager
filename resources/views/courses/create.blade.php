@extends('layouts.admin')

@section('title', 'Ajouter un Cours')

@section('content')
    <div class="mb-4">
        <a href="{{ route('courses.index') }}" class="text-blue-600 hover:underline">← Retour aux cours</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-lg mx-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Nouveau Cours</h2>
        
        <form action="{{ route('courses.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nom du cours</label>
                <input type="text" name="nom" class="w-full border rounded px-3 py-2" placeholder="Ex: Mathématiques Avancées" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Enseignant</label>
                <select name="teacher_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Sélectionner un enseignant</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Classe</label>
                <select name="class_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Sélectionner une classe</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->nom }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Enregistrer
            </button>
            <a href="{{ route('courses.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
        </form>
    </div>
@endsection