<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- PASTIKAN INI ADA

class TaskController extends Controller
{
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'deadline' => 'nullable|date',
        ]);

        $project = Project::findOrFail($projectId);
        
        
        if (!$project->users->contains(Auth::id())) {
            abort(403, 'Kamu tidak punya akses untuk menambah tugas di proyek ini.');
        }

        $maxOrder = Task::query()
                ->where('project_id', $projectId)
                ->where('status', 'todo')
                ->max('order');

        Task::create([
            'project_id' => $projectId,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'deadline' => $request->deadline,
            'status' => 'todo',
            'order' => $maxOrder ? $maxOrder + 1 : 0,
        ]);

        return back()->with('success', 'Tugas baru berhasil ditambahkan!');
    }
}