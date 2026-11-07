<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin de notes</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; font-size: 14px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #2563eb; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #2563eb; font-size: 26px; }
        .header p { margin: 5px 0 0 0; color: #666; }
        
        .info-box { margin-bottom: 30px; background-color: #f8fafc; padding: 15px; border-radius: 5px; border: 1px solid #e2e8f0; }
        .info-box p { margin: 5px 0; font-size: 15px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #cbd5e1; padding: 10px; text-align: left; }
        th { background-color: #f1f5f9; font-weight: bold; }
        
        .moyenne-box { text-align: right; margin-top: 20px; padding: 15px; background-color: #f8fafc; border: 1px solid #e2e8f0; }
        .moyenne-box span { font-size: 20px; font-weight: bold; }
        
        .footer { text-align: center; font-size: 11px; color: #94a3b8; margin-top: 60px; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h1> EduManager</h1>
        <p>Bulletin de notes officiel - Année scolaire 2026</p>
    </div>

    <div class="info-box">
        <p><strong>Nom complet :</strong> {{ $student->user->name }}</p>
        <p><strong>Email :</strong> {{ $student->user->email }}</p>
        <p><strong>Classe :</strong> {{ $student->classRoom->nom ?? 'Non assigné' }}</p>
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
            @forelse($student->grades as $grade)
            <tr>
                <td>{{ $grade->course->nom }}</td>
                <td style="text-transform: capitalize;">{{ $grade->type }}</td>
                <td style="font-weight: bold; color: {{ $grade->note >= 10 ? '#16a34a' : '#dc2626' }};">
                    {{ $grade->note }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center;">Aucune note enregistrée.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="moyenne-box">
        Moyenne Générale : <span style="color: {{ $average >= 10 ? '#16a34a' : '#dc2626' }};">{{ round($average, 2) }} / 20</span>
    </div>

    <div class="footer">
        Document généré automatiquement par EduManager le {{ date('d/m/Y') }}.
    </div>

</body>
</html>