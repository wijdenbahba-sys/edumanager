@extends('layouts.admin')

@section('title', 'Ajouter une Classe')

@section('content')
    <div class="mb-4">
        <a href="{{ route('classes.index') }}" class="text-blue-600 hover:underline">← Retour à la liste</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-lg mx-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Nouvelle Classe</h2>
        
        <form action="{{ route('classes.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nom de la classe</label>
                <input type="text" name="nom" class="w-full border rounded px-3 py-2" placeholder="Ex: 1ère A" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Niveau</label>
                <input type="text" name="niveau" class="w-full border rounded px-3 py-2" placeholder="Ex: 1ère" required>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Enregistrer
            </button>
        </form>
    </div>
@endsection