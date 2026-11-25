@extends('layouts.admin')

@section('title', 'Ajouter une Absence')

@section('content')
    <div class="mb-4">
        <a href="{{ route('absences.index') }}" class="text-blue-600 hover:underline">← Retour aux absences</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-lg mx-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Nouvelle Absence</h2>
        
        <form action="{{ route('absences.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Étudiant</label>
                <select name="student_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Choisir un étudiant --</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Cours</label>
                <select name="course_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Choisir un cours --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                <input type="date" name="date" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="justifiee" value="1" class="form-checkbox h-5 w-5 text-blue-600">
                    <span class="ml-2 text-gray-700">Justifiée ?</span>
                </label>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Enregistrer
            </button>
            <a href="{{ route('absences.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
        </form>
    </div>
@endsection