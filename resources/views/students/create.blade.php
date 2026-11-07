@extends('layouts.admin')

@section('title', 'Ajouter un Étudiant')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Nouvel Étudiant</h2>
        
        <form action="{{ route('students.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nom complet</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Date de naissance</label>
                <input type="date" name="date_naissance" class="w-full border rounded px-3 py-2" required>
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
                <a href="{{ route('students.index') }}" class="text-gray-600 mr-4 self-center">Annuler</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
@endsection