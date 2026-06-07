<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar CollabFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center font-['Plus_Jakarta_Sans'] p-4">
    
    <div class="bg-slate-900 border border-slate-800 p-8 rounded-2xl shadow-xl w-full max-w-md relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-600/10 rounded-full blur-2xl"></div>

        <div class="text-center mb-6">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Collab<span class="text-blue-500">Flow</span></h2>
            <p class="text-sm text-slate-400 mt-2">Buat akun baru untuk mengelola proyek tim</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Fathurrochim" 
                    class="w-full bg-slate-950 border border-slate-800 rounded-lg p-2.5 text-white placeholder-slate-600 focus:outline-none focus:border-blue-500 transition">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com" 
                    class="w-full bg-slate-950 border border-slate-800 rounded-lg p-2.5 text-white placeholder-slate-600 focus:outline-none focus:border-blue-500 transition">
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Password</label>
                <input type="password" name="password" required placeholder="Minimal 8 karakter" 
                    class="w-full bg-slate-950 border border-slate-800 rounded-lg p-2.5 text-white placeholder-slate-600 focus:outline-none focus:border-blue-500 transition">
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required placeholder="Ulangi password kamu" 
                    class="w-full bg-slate-950 border border-slate-800 rounded-lg p-2.5 text-white placeholder-slate-600 focus:outline-none focus:border-blue-500 transition">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold p-2.5 rounded-lg transition duration-200 mt-2 shadow-lg shadow-blue-600/20 hover:shadow-blue-500/30">
                Daftar Akun
            </button>
        </form>

        <p class="text-center text-sm text-slate-500 mt-6">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-400 hover:underline font-medium">Masuk di sini</a>
        </p>
    </div>

</body>
</html>