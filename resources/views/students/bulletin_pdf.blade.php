<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin - {{ $student->user->name }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #3b82f6; padding-bottom: 10px; }
        .header h1 { color: #3b82f6; margin: 0; }
        .info-box { background-color: #f3f4f6; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .info-box p { margin: 5px 0; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #e5e7eb; padding: 10px; text-align: left; }
        th { background-color: #f9fafb; font-weight: bold; }
        .footer { text-align: right; margin-top: 30px; font-size: 16px; }
        .average { font-weight: bold; color: #16a34a; font-size: 18px; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h1>EduManager</h1>
        <p>Bulletin de notes officiel - Année scolaire 2026</p>
    </div>

    <div class="info-box">
        <p><strong>Nom complet :</strong> {{ $student->user->name }}</p>
        <p><strong>Email :</strong> {{ $student->user->email }}</p>
        <p><strong>Classe :</strong> {{ $student->classRoom->nom ?? 'N/A' }}</p>
        <p><strong>Date de naissance :</strong> {{ $student->date_naissance }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Matière</th>
                <th>Type d'évaluation</th>
                <th>Note / 20</th>
            </tr>
        </thead>
        <tbody>
            @forelse($grades as $grade)
                <tr>
                    <td>{{ $grade->course->nom }}</td>
                    <td>{{ ucfirst($grade->type) }}</td>
                    <td>{{ number_format($grade->note, 2, '.', '') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Aucune note disponible.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Moyenne Générale : <span class="average">{{ number_format($average, 2, '.', '') }} / 20</span>
    </div>

    <div style="margin-top: 50px; text-align: center; font-size: 12px; color: #9ca3af;">
        Document généré automatiquement par EduManager le {{ date('d/m/Y') }}.
    </div>

</body>
</html>