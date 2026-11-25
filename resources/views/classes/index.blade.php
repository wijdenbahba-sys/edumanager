@extends('layouts.admin')

@section('title', 'Gestion des Classes')

@section('content')
    <div class="mb-4">
        <a href="{{ route('classes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Ajouter une classe
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Toutes les classes</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-2 px-4 border-b">Nom</th>
                    <th class="py-2 px-4 border-b">Niveau</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $classe)
                    <tr class="hover:bg-gray-50 border-b">
                        <td class="py-2 px-4">{{ $classe->nom }}</td>
                        <td class="py-2 px-4">{{ $classe->niveau }}</td>
                        <td class="py-2 px-4">
                            <form action="{{ route('classes.destroy', $classe->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-500">Aucune classe enregistrée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection