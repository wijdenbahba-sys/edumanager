<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model {
    protected $table = 'classes'; // On précise la table car "Class" est réservé en PHP
    protected $fillable = ['nom', 'niveau'];

    public function students() {
        return $this->hasMany(Student::class, 'class_id');
    }
    public function courses() {
        return $this->hasMany(Course::class, 'class_id');
    }
}