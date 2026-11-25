@extends('layouts.admin')

@section('title', 'Modifier un Étudiant')

@section('content')
    <div class="mb-4">
        <a href="{{ route('students.index') }}" class="text-blue-600 hover:underline">← Retour à la liste</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-lg mx-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Modifier l'Étudiant</h2>
        
        <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nom complet</label>
                <input type="text" name="name" value="{{ $student->user->name }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ $student->user->email }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Classe</label>
                <select name="class_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $student->class_id == $class->id ? 'selected' : '' }}>
                            {{ $class->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Date de naissance</label>
                <input type="date" name="date_naissance" value="{{ $student->date_naissance }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Mettre à jour
                </button>
                <a href="{{ route('students.index') }}" class="text-gray-600 hover:underline">Annuler</a>
            </div>
        </form>
    </div>
@endsection