<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter une note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('grades.store') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Étudiant</label>
                        <select name="student_id" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                            <option value="">-- Choisir un étudiant --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->user->name ?? 'Sans nom' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Cours</label>
                        <select name="course_id" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                            <option value="">-- Choisir un cours --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Note (sur 20)</label>
                        <input type="number" step="0.01" name="note" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Type</label>
                        <select name="type" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                            <option value="devoir">Devoir</option>
                            <option value="examen">Examen</option>
                            <option value="tp">TP</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                        <input type="date" name="date" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Enregistrer
                        </button>
                        <a href="{{ route('grades.index') }}" class="text-gray-600 hover:underline">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>