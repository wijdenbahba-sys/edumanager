@extends('layouts.admin')

@section('title', 'Profil de ' . $student->user->name)

@section('content')
    <div class="mb-4">
        <a href="{{ route('students.index') }}" class="text-blue-600 hover:underline">← Retour à la liste</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Carte Profil -->
        <div class="bg-white rounded-lg shadow p-6 md:col-span-1">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Informations</h2>
            <div class="space-y-3 text-gray-600">
                <p><strong>Nom :</strong> {{ $student->user->name }}</p>
                <p><strong>Email :</strong> {{ $student->user->email }}</p>
                <p><strong>Classe :</strong> <span class="bg-blue-100 text-blue-800 py-1 px-2 rounded text-sm">{{ $student->classRoom->nom ?? 'Aucune' }}</span></p>
                <p><strong>Né(e) le :</strong> {{ $student->date_naissance }}</p>
            </div>
        </div>

        <!-- Carte Notes -->
        <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
            
            <!-- Titre et Boutons d'action -->
                       <!-- Titre et Boutons d'action -->
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                <a href="{{ route('students.absences', $student->id) }}" style="background-color: #ea580c; color: white; padding: 8px 16px; text-decoration: none; border-radius: 5px; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    Gérer les Absences
                </a>
                
                <a href="{{ route('students.bulletin.download', $student->id) }}" style="background-color: #16a34a; color: white; padding: 8px 16px; text-decoration: none; border-radius: 5px; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    Télécharger le Bulletin PDF
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tableau des notes -->
            <table class="w-full text-left border-collapse mb-6">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-2 px-4">Matière</th>
                        <th class="py-2 px-4">Type</th>
                        <th class="py-2 px-4 text-center">Note /20</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse($student->grades as $grade)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-2 px-4 font-medium">{{ $grade->course->nom }}</td>
                        <td class="py-2 px-4 capitalize">{{ $grade->type }}</td>
                        <td class="py-2 px-4 text-center">
                            <span class="font-bold {{ $grade->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $grade->note }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-400">Aucune note pour le moment.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Formulaire d'ajout de note -->
              @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('teacher'))
            <div class="bg-gray-50 p-4 rounded border border-gray-200">
                <h3 class="font-bold text-gray-700 mb-3">Ajouter une note</h3>
                <form action="{{ route('students.addGrade', $student->id) }}" method="POST" class="flex items-end gap-3">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-sm text-gray-600 mb-1">Matière</label>
                        <select name="course_id" class="w-full border rounded px-2 py-1" required>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-32">
                        <label class="block text-sm text-gray-600 mb-1">Type</label>
                        <select name="type" class="w-full border rounded px-2 py-1" required>
                            <option value="devoir">Devoir</option>
                            <option value="examen">Examen</option>
                            <option value="tp">TP</option>
                        </select>
                    </div>
                    <div class="w-24">
                        <label class="block text-sm text-gray-600 mb-1">Note /20</label>
                        <input type="number" name="note" step="0.25" min="0" max="20" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded h-9">
                        Ajouter
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
        <!-- Graphique mte3 les notes mte3 l'étudiant -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Évolution des notes par matière</h2>
        <canvas id="studentGradesChart" height="100"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('studentGradesChart').getContext('2d');
        
        // Njibou les notes mte3 l'étudiant mel blade
        const grades = @json($grades);
        
        // Na3mlou les labels w les data
        const labels = grades.map(g => g.course.nom);
        const data = grades.map(g => g.note);

        const myChart = new Chart(ctx, {
            type: 'bar', // Des barres (kima el dashboard)
            data: {
                labels: labels,
                datasets: [{
                    label: 'Note / 20',
                    data: data,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)', // Loun zr9a
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1,
                    borderRadius: 5, // zwaya m dawrin
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, max: 20 }
                },
                plugins: {
                    legend: { display: false } // N7iyna el legende bch tban hayla
                }
            }
        });
    </script>
@endsection