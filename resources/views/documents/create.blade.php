@extends('layouts.admin')

@section('title', 'Ajouter un Support de Cours')

@section('content')
    <div class="mb-4">
        <a href="{{ route('documents.index') }}" class="text-blue-600 hover:underline">← Retour aux documents</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-lg mx-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Nouveau Document</h2>
        
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Cours</label>
                <select name="course_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Titre du document</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Type</label>
                <select name="type" class="w-full border rounded px-3 py-2" required>
                    <option value="cours">Cours</option>
                    <option value="td">TD</option>
                    <option value="tp">TP</option>
                    <option value="examen">Examen</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Fichier (PDF, Word, PPT)</label>
                <input type="file" name="file" class="w-full border rounded px-3 py-2" required>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Ajouter
            </button>
        </form>
    </div>
@endsection