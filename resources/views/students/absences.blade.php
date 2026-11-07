@extends('layouts.admin')

@section('title', 'Absences de ' . $student->user->name)

@section('content')
    <div class="mb-4">
        <a href="{{ route('students.show', $student->id) }}" class="text-blue-600 hover:underline">← Retour au profil de l'étudiant</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-4xl mx-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Gestion des absences : {{ $student->user->name }}</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tableau des absences -->
        <table class="w-full text-left border-collapse mb-8">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-2 px-4">Date</th>
                    <th class="py-2 px-4">Cours manqué</th>
                    <th class="py-2 px-4 text-center">Statut</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($student->absences as $absence)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-2 px-4">{{ \Carbon\Carbon::parse($absence->date)->format('d/m/Y') }}</td>
                    <td class="py-2 px-4 font-medium">{{ $absence->course->nom }}</td>
                    <td class="py-2 px-4 text-center">
                        @if($absence->justifiee)
                            <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold">Justifiée</span>
                        @else
                            <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs font-bold">Non justifiée</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-gray-400">Aucune absence enregistrée pour cet étudiant.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Formulaire d'ajout d'absence -->
        <div class="bg-gray-50 p-4 rounded border border-gray-200">
            <h3 class="font-bold text-gray-700 mb-3">Déclarer une nouvelle absence</h3>
            <form action="{{ route('students.addAbsence', $student->id) }}" method="POST" class="flex items-end gap-4">
                @csrf
                <div class="flex-1">
                    <label class="block text-sm text-gray-600 mb-1">Matière / Cours</label>
                    <select name="course_id" class="w-full border rounded px-3 py-2" required>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-48">
                    <label class="block text-sm text-gray-600 mb-1">Date de l'absence</label>
                    <input type="date" name="date" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="flex items-center h-10 mb-1">
                    <input type="checkbox" name="justifiee" id="justifiee" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                    <label for="justifiee" class="ml-2 text-sm text-gray-700 font-medium">Justifiée ?</label>
                </div>
                <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded h-10">
                    Enregistrer
                </button>
            </form>
        </div>
    </div>
@endsection