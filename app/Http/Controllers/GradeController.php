<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with(['student.user', 'course'])->get();
        return view('grades.index', compact('grades'));
    }

    public function create()
    {
        $students = Student::with('user')->get();
        $courses = Course::all();
        return view('grades.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'note' => 'required|numeric|min:0|max:20',
            'type' => 'required|string',
            'date' => 'required|date'
        ]);

        Grade::create($request->all());

        return redirect()->route('grades.index')->with('success', 'Note ajoutée avec succès.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades.index')->with('success', 'Note supprimée.');
    }
}