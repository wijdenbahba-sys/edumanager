@extends('layouts.admin')

@section('title', 'Documents du cours : ' . $course->nom)

@section('content')
    <div class="mb-4">
        <a href="{{ route('documents.index') }}" class="text-blue-600 hover:underline">← Retour aux cours</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">📚 {{ $course->nom }} - Documents</h2>
        
        <div class="space-y-3">
            @forelse($documents as $doc)
                <div class="p-4 rounded-lg border border-gray-200 flex justify-between items-center bg-gray-50">
                    <div>
                        <p class="font-bold text-gray-800">{{ $doc->title }}</p>
                        <p class="text-sm text-gray-500">
                            <span class="font-bold text-blue-600">{{ strtoupper($doc->type) }}</span> 
                            - Ajouté le {{ $doc->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">Télécharger</a>
                        
                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('teacher'))
                            <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm font-bold">Supprimer</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center w-full">Aucun document disponible pour ce cours.</p>
            @endforelse
        </div>
    </div>
@endsection