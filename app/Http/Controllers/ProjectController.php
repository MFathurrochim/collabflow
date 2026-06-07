<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Menampilkan semua proyek yang diikuti oleh user di Dashboard
     */
    public function index()
    {
        // Ambil data user yang sedang login beserta proyek yang diikutinya
        $user = Auth::user();
        $projects = $user->projects()->get();

        return view('dashboard', compact('projects'));
    }

    /**
     * Memproses pembuatan proyek baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // 1. Generate kode acak unik untuk proyek (Contoh: CF-A8F2D)
        do {
    $code = 'CF-' . strtoupper(Str::random(5));
} while (Project::whereCode($code)->exists());

        // 2. Simpan data proyek ke tabel 'projects'
        $project = Project::create([
            'name' => $request->name,
            'code' => $code,
            'creator_id' => Auth::id(), // Penciptanya adalah user yang login
        ]);

        // 3. Otomatis masukkan pencipta proyek ke tabel pivot 'project_user' sebagai 'owner'
        $project->users()->attach(Auth::id(), ['role' => 'owner']);

        return redirect()->route('dashboard')->with('success', 'Proyek baru berhasil dibuat!');
    }

    /**
     * Memproses user bergabung ke proyek lain menggunakan kode akses
     */
    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        // 1. Cari proyek berdasarkan kode yang dimasukkan
        $project = Project::whereCode(strtoupper($request->code))->first();

        if (!$project) {
            return response()->json(['error_message' => 'Waduh, kode proyek tidak ditemukan!'], 404);
        }

        // 2. Cek apakah user sudah bergabung di proyek ini sebelumnya
        if ($project->users()->where('user_id', Auth::id())->exists()) {
            return response()->json(['error_message' => 'Kamu sudah bergabung di dalam proyek ini.'], 400);
        }

        // 3. Daftarkan user ke tabel pivot 'project_user' dengan role default 'member'
        $project->users()->attach(Auth::id(), ['role' => 'member']);

        return response()->json(['success' => true]);

    }
    /**
 * Menampilkan Papan Kerja / Kanban Board berdasarkan ID Proyek
 */
public function show(string $id)
{
    // 1. Cari proyek berdasarkan ID, sekalian ambil data user pembuatnya
    $project = Project::with('creator')->findOrFail($id);

    // 2. KEAMANAN: Pastikan user yang sedang login adalah anggota dari proyek ini
    if (!$project->users->contains(Auth::id())) {
        abort(403, 'Waduh, kamu tidak terdaftar di dalam proyek ini!');
    }

    // 3. Ambil semua tugas di proyek ini dan kelompokkan berdasarkan statusnya
    $tasks = $project->tasks()->orderBy('order')->get();
    
    $todoTasks = $tasks->where('status', 'todo');
    $inprogressTasks = $tasks->where('status', 'inprogress');
    $doneTasks = $tasks->where('status', 'done');

    // 4. Ambil daftar semua anggota tim di proyek ini untuk keperluan assign tugas nanti
    $teamMembers = $project->users;

    return view('projects.board', compact('project', 'todoTasks', 'inprogressTasks', 'doneTasks', 'teamMembers'));
}
    
}
