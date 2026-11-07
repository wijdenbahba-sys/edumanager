@extends('layouts.admin')

@section('title', 'Tableau de bord principal')

@section('content')
    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <!-- Étudiants -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="text-gray-500 text-sm font-semibold">Total Étudiants</div>
            <div class="text-3xl font-bold text-gray-800">{{ $totalStudents }}</div>
        </div>
        <!-- Enseignants -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="text-gray-500 text-sm font-semibold">Enseignants</div>
            <div class="text-3xl font-bold text-gray-800">{{ $totalTeachers }}</div>
        </div>
        <!-- Cours -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="text-gray-500 text-sm font-semibold">Cours Actifs</div>
            <div class="text-3xl font-bold text-gray-800">{{ $totalCourses }}</div>
        </div>
        <!-- Moyenne Générale -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <div class="text-gray-500 text-sm font-semibold">Moyenne Générale</div>
            <div class="text-3xl font-bold text-gray-800">{{ round($averageGrade, 2) }} / 20</div>
        </div>
    </div>

    <!-- Graphique -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Moyenne des notes par matière</h2>
        <canvas id="gradesChart" height="100"></canvas>
    </div>

    <!-- Script du Graphique -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('gradesChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar', // Type de graphique (barres)
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Moyenne / 20',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(139, 92, 246, 0.7)'
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(139, 92, 246, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, max: 20 } // La note max est 20
                }
            }
        });
    </script>
@endsection