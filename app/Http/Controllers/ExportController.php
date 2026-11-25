<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Grade;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    // Export mte3 les étudiants (CSV)
    public function students()
    {
        $students = Student::with(['user', 'classRoom'])->get();

        $filename = "etudiants_" . date('Y-m-d') . ".csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Nom', 'Email', 'Classe', 'Date de naissance']);

        foreach ($students as $student) {
            fputcsv($handle, [
                $student->user->name,
                $student->user->email,
                $student->classRoom->nom ?? 'N/A',
                $student->date_naissance,
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    // Export mte3 les notes (CSV)
    public function grades()
    {
        $grades = Grade::with(['student.user', 'course'])->get();

        $filename = "notes_" . date('Y-m-d') . ".csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Étudiant', 'Cours', 'Note', 'Type', 'Date']);

        foreach ($grades as $grade) {
            fputcsv($handle, [
                $grade->student->user->name,
                $grade->course->nom,
                $grade->note,
                $grade->type,
                $grade->date,
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}