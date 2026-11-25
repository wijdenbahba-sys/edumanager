<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        // N7awlou n7assou fil users (Admin, Prof, Etudiant)
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->get();

        // N7assou fil cours
        $courses = Course::where('nom', 'LIKE', "%{$query}%")->get();

        return view('search.index', compact('users', 'courses', 'query'));
    }
}