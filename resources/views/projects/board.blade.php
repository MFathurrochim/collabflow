<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papan {{ $project->name }} - CollabFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen font-['Plus_Jakarta_Sans']" x-data="{ openTaskModal: false }">

    <header class="bg-slate-900 border-b border-slate-800 px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition">&larr; Kembali ke Dashboard</a>
                <span>/</span>
                <span class="text-slate-500">Papan Kerja</span>
            </div>
            <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                {{ $project->name }}
                <span class="bg-slate-800 text-slate-400 font-mono text-xs px-2.5 py-1 rounded border border-slate-700 font-semibold tracking-wider">
                    {{ $project->code }}
                </span>
            </h1>
        </div>
        
        <div>
            <button @click="openTaskModal = true" class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-blue-600/10 transition">
                + Tambah Tugas
            </button>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
        
        <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col min-h-[500px]">
            <div class="flex items-center justify-between mb-4 px-1">
                <h3 class="font-bold text-slate-300 text-sm tracking-wide uppercase flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-slate-500"></span> To Do
                </h3>
                <span class="text-xs bg-slate-800 text-slate-400 font-medium px-2 py-0.5 rounded-md border border-slate-700/60">{{ $todoTasks->count() }}</span>
            </div>
            
            <div class="space-y-3 flex-1 overflow-y-auto">
                @foreach($todoTasks as $task)
                    <div class="bg-slate-900 border border-slate-800 p-4 rounded-xl shadow-sm hover:border-slate-700 transition">
                        <span class="inline-block text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded mb-2 
                            {{ $task->priority == 'high' ? 'bg-rose-500/10 text-rose-400 border border-rose-500/20' : ($task->priority == 'medium' ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20') }}">
                            {{ $task->priority }}
                        </span>
                        <h4 class="font-semibold text-white text-sm leading-snug">{{ $task->title }}</h4>
                        @if($task->description)
                            <p class="text-xs text-slate-400 mt-1 line-clamp-2 leading-relaxed">{{ $task->description }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col min-h-[500px]">
            <div class="flex items-center justify-between mb-4 px-1">
                <h3 class="font-bold text-blue-400 text-sm tracking-wide uppercase flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span> In Progress
                </h3>
                <span class="text-xs bg-slate-800 text-slate-400 font-medium px-2 py-0.5 rounded-md border border-slate-700/60">{{ $inprogressTasks->count() }}</span>
            </div>

            <div class="space-y-3 flex-1 overflow-y-auto">
                @foreach($inprogressTasks as $task)
                    <div class="bg-slate-900 border border-slate-800 p-4 rounded-xl shadow-sm">
                        <h4 class="font-semibold text-white text-sm leading-snug">{{ $task->title }}</h4>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col min-h-[500px]">
            <div class="flex items-center justify-between mb-4 px-1">
                <h3 class="font-bold text-emerald-400 text-sm tracking-wide uppercase flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Done
                </h3>
                <span class="text-xs bg-slate-800 text-slate-400 font-medium px-2 py-0.5 rounded-md border border-slate-700/60">{{ $doneTasks->count() }}</span>
            </div>

            <div class="space-y-3 flex-1 overflow-y-auto">
                @foreach($doneTasks as $task)
                    <div class="bg-slate-900 border border-slate-800 p-4 rounded-xl shadow-sm opacity-60 line-through">
                        <h4 class="font-semibold text-slate-300 text-sm leading-snug">{{ $task->title }}</h4>
                    </div>
                @endforeach
            </div>
        </div>

    </main>

    <div x-show="openTaskModal" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm" @click="openTaskModal = false"></div>

        <div class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full p-6 z-10 space-y-4 shadow-2xl">
            <h3 class="text-lg font-bold text-white">Buat Tugas Baru</h3>
            
            <form action="{{ route('tasks.store', $project->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Judul Tugas</label>
                    <input type="text" name="title" required placeholder="Contoh: Slicing Login Page" class="w-full bg-slate-950 border border-slate-800 rounded-lg p-2.5 text-white focus:outline-none focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" placeholder="Jelaskan detail detail tugas..." class="w-full bg-slate-950 border border-slate-800 rounded-lg p-2.5 text-white text-sm focus:outline-none focus:border-blue-500 transition"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Prioritas</label>
                        <select name="priority" class="w-full bg-slate-950 border border-slate-800 rounded-lg p-2.5 text-sm text-white focus:outline-none focus:border-blue-500 transition">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Tenggat Waktu</label>
                        <input type="date" name="deadline" class="w-full bg-slate-950 border border-slate-800 rounded-lg p-2 text-sm text-white focus:outline-none focus:border-blue-500 transition">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="openTaskModal = false" class="px-4 py-2 border border-slate-800 rounded-lg text-sm text-slate-400 hover:bg-slate-800 hover:text-white transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-sm font-semibold shadow-lg shadow-blue-600/10 transition">Simpan Tugas</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>