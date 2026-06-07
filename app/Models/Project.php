<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Sesuai dengan skema database asli kamu
    protected $fillable = [
        'name',
        'code',
        'creator_id',
    ];

    /**
     * Relasi ke User yang membuat proyek ini (Many-to-One)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Relasi ke Anggota Tim yang bergabung di proyek ini (Many-to-Many via Pivot)
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /**
     * Relasi ke Tugas/Tasks di dalam proyek ini (One-to-Many)
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');
    }
}