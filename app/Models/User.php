<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // <-- Zid hadhi

class User extends Authenticatable
{
    use HasFactory, Notifiable; // <--- C'est ici qu'on ajoute HasFactory
    use HasRoles; 
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',  
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function student() {
        return $this->hasOne(Student::class);
    }
    
    public function teacher() {
        return $this->hasOne(Teacher::class);
    }
        public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isTeacher()
    {
        return $this->hasRole('teacher');
    }

    public function isStudent()
    {
        return $this->hasRole('student');
    }
}