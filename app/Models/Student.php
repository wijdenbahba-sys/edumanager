<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Student extends Model {
    protected $fillable = ['user_id', 'class_id', 'date_naissance'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function classRoom() {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
    public function courses() {
        return $this->belongsToMany(Course::class, 'enrollments');
    }
    public function grades() {
        return $this->hasMany(Grade::class);
    }
}