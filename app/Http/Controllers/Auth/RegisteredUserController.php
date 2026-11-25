<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
       public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:student,teacher'], // Nzidou el validation mte3 el rôle
        ]);

        // 1. Na3mlou el User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 2. Na3tiw el Rôle
        $user->assignRole($request->role);

        // 3. Na3mlou el Profil (Etudiant wala Teacher)
        if ($request->role === 'student') {
            $class = \App\Models\ClassRoom::first(); // El classe par défaut
            \App\Models\Student::create([
                'user_id' => $user->id,
                'class_id' => $class ? $class->id : null, // Ila ma fama classe, ykoun null
            ]);
        } elseif ($request->role === 'teacher') {
            \App\Models\Teacher::create([
                'user_id' => $user->id,
                'matiere_principale' => 'Non définie',
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
