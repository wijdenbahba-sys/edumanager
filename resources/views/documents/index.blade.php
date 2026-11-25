@extends('layouts.admin')

@section('title', 'Support de Cours')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">💻 Supports de cours</h1>
        
        <div class="flex items-center gap-3">
            @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('courses.index') }}" style="background-color: #1e293b; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none; font-weight: bold;">
                    ⚙️ Gérer les Cours
                </a>
            @endif
            
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('teacher'))
                                   <a href="{{ route('export.grades') }}" style="background-color: #16a34a; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block;">
            📥 Exporter les Notes
        </a>
                <a href="{{ route('documents.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                    + Ajouter un document
                </a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Les Cartes mte3 les Cours (bch nbadlou $documents b $courses) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($courses as $course)
            <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden hover:shadow-lg transition duration-200">
                <div class="bg-blue-50 p-3 border-b border-blue-100 flex justify-between items-center">
                    <span class="text-blue-800 font-bold text-sm">📚 {{ $course->nom }}</span>
                    <span class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">Cours</span>
                </div>
                
                <div class="p-4">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $course->nom }}</h3>
                    
                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                        <div class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">
                            {{ substr($course->teacher->user->name ?? 'P', 0, 1) }}
                        </div>
                        {{ $course->teacher->user->name ?? 'Prof non défini' }}
                    </div>

                    <div class="flex flex-wrap gap-2 text-xs text-gray-500 mb-4">
                        <span class="bg-gray-100 px-2 py-1 rounded">📅 Semestre 1</span>
                        <span class="bg-gray-100 px-2 py-1 rounded">👨‍🎓 Classe: {{ $course->classRoom->nom ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 border-t border-gray-100 flex justify-between items-center">
                    <span class="text-sm text-gray-500">📁 {{ $course->documents->count() }} fichiers</span>
                    <a href="{{ route('documents.show', $course->id) }}" class="bg-blue-100 text-blue-700 hover:bg-blue-600 hover:text-white px-3 py-1 rounded text-sm font-bold transition">
                        Afficher →
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-10 bg-white rounded-lg shadow">
                <p class="text-gray-500">Aucun cours disponible pour le moment.</p>
            </div>
        @endforelse
    </div>
@endsection