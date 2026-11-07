@extends('layouts.admin')

@section('title', 'Liste des Enseignants')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">Tous les enseignants</h2>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6">Nom</th>
                    <th class="py-3 px-6">Email</th>
                    <th class="py-3 px-6">Matière Principale</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($teachers as $teacher)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6 font-medium">{{ $teacher->user->name }}</td>
                    <td class="py-3 px-6">{{ $teacher->user->email }}</td>
                    <td class="py-3 px-6">
                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">
                            {{ $teacher->matiere_principale }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('Supprimer cet enseignant ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-4">
            {{ $teachers->links() }}
        </div>
    </div>
@endsection
