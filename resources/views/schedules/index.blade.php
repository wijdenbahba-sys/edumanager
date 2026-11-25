@extends('layouts.admin')

@section('title', 'Emploi du Temps')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">📅 Emploi du Temps</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulaire mte3 l'ajout (Ghir l'admin wala prof) -->
    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('teacher'))
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-700 mb-3">Ajouter une séance</h2>
        <form action="{{ route('schedules.store') }}" method="POST" class="flex flex-wrap gap-3 items-end">
            @csrf
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm text-gray-600 mb-1">Cours</label>
                <select name="course_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-32">
                <label class="block text-sm text-gray-600 mb-1">Jour</label>
                <select name="day" class="w-full border rounded px-3 py-2" required>
                    <option value="Lundi">Lundi</option>
                    <option value="Mardi">Mardi</option>
                    <option value="Mercredi">Mercredi</option>
                    <option value="Jeudi">Jeudi</option>
                    <option value="Vendredi">Vendredi</option>
                    <option value="Samedi">Samedi</option>
                </select>
            </div>
            <div class="w-28">
                <label class="block text-sm text-gray-600 mb-1">Début</label>
                <input type="time" name="start_time" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="w-28">
                <label class="block text-sm text-gray-600 mb-1">Fin</label>
                <input type="time" name="end_time" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="w-24">
                <label class="block text-sm text-gray-600 mb-1">Salle</label>
                <input type="text" name="room" class="w-full border rounded px-3 py-2" placeholder="Salle 1">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded h-10">
                Ajouter
            </button>
        </form>
    </div>
    @endif

    <!-- El Tableau mte3 l'emploi du temps -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-4">Jour</th>
                    <th class="py-3 px-4">Horaire</th>
                    <th class="py-3 px-4">Cours</th>
                    <th class="py-3 px-4">Enseignant</th>
                    <th class="py-3 px-4">Salle</th>
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('teacher'))
                    <th class="py-3 px-4 text-center">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($schedules as $schedule)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-4 font-bold text-blue-700">{{ $schedule->day }}</td>
                        <td class="py-3 px-4">{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                        <td class="py-3 px-4 font-medium">{{ $schedule->course->nom }}</td>
                        <td class="py-3 px-4">{{ $schedule->course->teacher->user->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4"><span class="bg-gray-200 px-2 py-1 rounded">{{ $schedule->room ?? 'N/A' }}</span></td>
                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('teacher'))
                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline text-sm font-bold">Supprimer</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">Aucune séance dans l'emploi du temps pour le moment.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection