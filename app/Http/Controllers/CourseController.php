<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        // On récupère les cours avec le prof et la classe associés
        $courses = Course::with(['teacher.user', 'classRoom'])->paginate(10);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $teachers = Teacher::with('user')->get();
        $classes = ClassRoom::all();
        return view('courses.create', compact('teachers', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Cours ajouté avec succès !');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Cours supprimé !');
    }
}