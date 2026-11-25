<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        // Njibou el planning m3a el cours w el prof mte3ou
        $schedules = Schedule::with(['course.teacher.user'])->orderBy('start_time')->get();
        $courses = Course::all(); // bch nzidou planning jdid
        return view('schedules.index', compact('schedules', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'room' => 'nullable|string',
        ]);

        Schedule::create($request->all());
        return redirect()->route('schedules.index')->with('success', 'Emploi du temps ajouté.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Emploi du temps supprimé.');
    }
}