@extends('layouts.admin')

@section('title', 'Ajouter un Cours')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Nouveau Cours</h2>
        
        <form action="{{ route('courses.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nom du cours</label>
                <input type="text" name="nom" class="w-full border rounded px-3 py-2" required placeholder="Ex: Mathématiques Avancées">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Enseignant</label>
                <select name="teacher_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Sélectionner un enseignant</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->user->name }} ({{ $teacher->matiere_principale }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Classe</label>
                <select name="class_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Sélectionner une classe</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('courses.index') }}" class="text-gray-600 mr-4 self-center">Annuler</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
@endsection