<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['nom', 'teacher_id', 'class_id'];

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }
    
    // C'est cette relation qui manquait !
    public function classRoom() {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function students() {
        return $this->belongsToMany(Student::class, 'enrollments');
    }

    public function grades() {
        return $this->hasMany(Grade::class);
    }
}