<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Sesuai dengan kolom di tabel `tasks` skema database kamu
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'deadline',
        'assigned_to',
        'order',
    ];

    /**
     * Relasi balik ke Proyek (Many-to-One)
     * Setiap tugas pasti bagian dari satu proyek spesifik.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Relasi ke User yang ditunjuk/diberi tugas (Many-to-One)
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}