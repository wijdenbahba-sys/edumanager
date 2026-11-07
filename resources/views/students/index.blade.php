@extends('layouts.admin')

@section('title', 'Liste des Étudiants')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">Tous les étudiants</h2>
            <a href="{{ route('students.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Ajouter un étudiant
            </a>
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
                    <th class="py-3 px-6">Classe</th>
                    <th class="py-3 px-6">Date de naissance</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($students as $student)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6 font-medium">{{ $student->user->name }}</td>
                    <td class="py-3 px-6">{{ $student->user->email }}</td>
                    <td class="py-3 px-6">
                        <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs">
                            {{ $student->classRoom ? $student->classRoom->nom : 'Aucune' }}
                        </span>
                    </td>
                    <td class="py-3 px-6">{{ $student->date_naissance }}</td>
                    
                    <!-- COLONNE ACTIONS CORRIGÉE -->
                    <td class="py-3 px-6 text-center">
                        <div class="flex items-center justify-center gap-4">
                            <a href="{{ route('students.show', $student->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Voir</a>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Supprimer cet étudiant ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Supprimer</button>
                            </form>
                        </div>
                    </td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>
@endsection