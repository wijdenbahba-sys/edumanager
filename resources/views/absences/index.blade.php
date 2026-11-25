@extends('layouts.admin')

@section('title', 'Liste des Absences')

@section('content')
    <div class="mb-4">
        <a href="{{ route('absences.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
            + Ajouter une absence
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Toutes les absences</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-2 px-4 border-b">Étudiant</th>
                    <th class="py-2 px-4 border-b">Cours</th>
                    <th class="py-2 px-4 border-b">Date</th>
                    <th class="py-2 px-4 border-b">Statut</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absences as $absence)
                    <tr class="hover:bg-gray-50 border-b">
                        <td class="py-2 px-4">{{ $absence->student->user->name ?? 'N/A' }}</td>
                        <td class="py-2 px-4">{{ $absence->course->nom ?? 'N/A' }}</td>
                        <td class="py-2 px-4">{{ $absence->date }}</td>
                        <td class="py-2 px-4">
                            @if($absence->justifiee)
                                <span class="text-green-600 font-bold">Justifiée</span>
                            @else
                                <span class="text-red-600 font-bold">Non justifiée</span>
                            @endif
                        </td>
                        <td class="py-2 px-4">
                            <form action="{{ route('absences.destroy', $absence->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Aucune absence enregistrée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection