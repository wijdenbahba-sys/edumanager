<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    // 1. Affichage mte3 el liste mte3 absences
    public function index()
    {
        $absences = Absence::with(['student.user', 'course'])->get();
        return view('absences.index', compact('absences')); 
    }

    // 2. Formulaire bch tzid absence
    public function create()
    {
        $students = Student::with('user')->get();
        $courses = Course::all();
        return view('absences.create', compact('students', 'courses'));
    }

    // 3. Enregistrer fi base de données
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'justifiee' => 'nullable|boolean'
        ]);

        Absence::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'date' => $request->date,
            'justifiee' => $request->has('justifiee') ? 1 : 0,
        ]);

        return redirect()->route('absences.index')->with('success', 'Absence enregistrée avec succès.');
    }

    // 4. Supprimer absence
    public function destroy(Absence $absence)
    {
        $absence->delete();
        return redirect()->route('absences.index')->with('success', 'Absence supprimée.');
    }
}