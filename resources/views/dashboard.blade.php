<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CollabFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen font-['Plus_Jakarta_Sans']" x-data="{ openJoinModal: false, projectCode: '', errorMessage: '' }">

    <nav class="bg-slate-900 border-b border-slate-800 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="font-bold text-xl tracking-tight text-white">Collab<span class="text-blue-500">Flow</span></span>
            <span class="text-xs bg-slate-800 text-slate-400 px-2 py-0.5 rounded border border-slate-700">Workspace</span>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-slate-300 font-medium">Halo, {{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs bg-rose-600/10 text-rose-400 hover:bg-rose-600 hover:text-white border border-rose-500/20 px-3 py-1.5 rounded-lg transition duration-200">
                    Keluar
                </button>
            </form>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10 space-y-8">
        
        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-white">Mulai Kolaborasi Proyek</h2>
                <p class="text-sm text-slate-400 mt-1">Buat ruang kerja baru atau gabung ke proyek tim kamu dengan kode akses.</p>
            </div>
            <div>
                <button @click="openJoinModal = true" class="w-full md:w-auto bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-sm px-5 py-2.5 rounded-xl border border-slate-700 transition duration-200">
                    Join Project via Code
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="lg:col-span-2 bg-slate-900 border border-slate-800 p-6 rounded-2xl space-y-4">
                <h3 class="text-lg font-bold text-white">Proyek Kamu</h3>
                
                @if($projects->isEmpty())
                    <div class="text-center py-12 border border-dashed border-slate-800 rounded-xl text-slate-500 text-sm">
                        Kamu belum memiliki atau bergabung ke proyek mana pun.
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($projects as $project)
                            <div class="bg-slate-950 border border-slate-800/80 p-5 rounded-xl flex flex-col justify-between hover:border-blue-500/50 transition duration-200 group">
                                <div>
                                    <h4 class="font-bold text-white text-lg group-hover:text-blue-400 transition">{{ $project->name }}</h4>
                                    <span class="inline-block bg-blue-500/10 text-blue-400 font-mono text-xs font-bold px-2 py-0.5 rounded mt-1.5 border border-blue-500/20 tracking-wider">
                                        {{ $project->code }}
                                    </span>
                                </div>
                                <div class="mt-6 pt-3 border-t border-slate-900 flex justify-between items-center text-xs">
                                    <span class="text-slate-400">Role: <strong class="text-slate-200 capitalize font-medium">{{ $project->pivot->role }}</strong></span>
                                    <a href="{{ route('projects.show', $project->id) }}"derline">Buka Papan &rarr;</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl space-y-4">
                <h3 class="text-lg font-bold text-white">Buat Proyek Baru</h3>
                <form action="{{ route('projects.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Nama Proyek</label>
                        <input type="text" name="name" required placeholder="Contoh: Web Bakso Balungan" 
                            class="w-full bg-slate-950 border border-slate-800 rounded-lg p-2.5 text-white placeholder-slate-700 focus:outline-none focus:border-blue-500 transition">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold p-2.5 rounded-lg transition duration-200 shadow-lg shadow-blue-600/10">
                        Buat Sekarang
                    </button>
                </form>
            </div>
        </div>

        <div x-show="openJoinModal" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4" x-cloak>
            <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm" @click="openJoinModal = false"></div>

            <div class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full p-6 z-10 space-y-4 shadow-2xl">
                <h3 class="text-lg font-bold text-white">Masuk ke Proyek Tim</h3>
                <p class="text-xs text-slate-400 leading-relaxed">Mintalah kode proyek (Contoh: CF-XXXXX) kepada pemilik proyek untuk bergabung ke papan kerja mereka.</p>
                
                <div>
                    <input type="text" x-model="projectCode" placeholder="Masukkan Kode Proyek" class="w-full bg-slate-950 border border-slate-800 rounded-lg p-2.5 text-white font-mono uppercase tracking-widest focus:outline-none focus:border-blue-500 transition">
                    <p x-show="errorMessage" x-text="errorMessage" class="text-rose-500 text-xs mt-1.5" x-cloak></p>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button @click="openJoinModal = false; errorMessage = ''; projectCode = ''" class="px-4 py-2 border border-slate-800 rounded-lg text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition">
                        Batal
                    </button>
                    <button @click="
                        errorMessage = '';
                        if(!projectCode) { errorMessage = 'Kode tidak boleh kosong!'; return; }
                        axios.post('{{ route('projects.join') }}', { code: projectCode })
                            .then(response => {
                                if(response.data.success) { window.location.reload(); }
                            })
                            .catch(error => {
                                errorMessage = error.response.data.error_message || 'Terjadi kesalahan sistem.';
                            });
                    " class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-sm font-medium shadow-lg shadow-blue-600/10 transition">
                        Gabung Proyek
                    </button>
                </div>
            </div>
        </div>

    </main>

</body>
</html>