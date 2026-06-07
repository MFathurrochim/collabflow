<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk CollabFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center font-['Plus_Jakarta_Sans'] p-4">
    
    <div class="bg-slate-900 border border-slate-800 p-8 rounded-2xl shadow-xl w-full max-w-md relative overflow-hidden">
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-blue-600/10 rounded-full blur-2xl"></div>

        <div class="text-center mb-6">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Collab<span class="text-blue-500">Flow</span></h2>
            <p class="text-sm text-slate-400 mt-2">Selamat datang kembali! Silakan masuk ke papan kerja</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com" 
                    class="w-full bg-slate-950 border border-slate-800 rounded-lg p-2.5 text-white placeholder-slate-600 focus:outline-none focus:border-blue-500 transition">
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Password</label>
                <input type="password" name="password" required placeholder="Masukkan password" 
                    class="w-full bg-slate-950 border border-slate-800 rounded-lg p-2.5 text-white placeholder-slate-600 focus:outline-none focus:border-blue-500 transition">
            </div>

            <div class="flex items-center justify-between text-sm pt-1">
                <label class="flex items-center text-slate-400 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-slate-950 border-slate-800 text-blue-600 focus:ring-0 focus:ring-offset-0 mr-2"> 
                    Ingat saya di perangkat ini
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold p-2.5 rounded-lg transition duration-200 mt-2 shadow-lg shadow-blue-600/20 hover:shadow-blue-500/30">
                Masuk Sekarang
            </button>
        </form>

        <p class="text-center text-sm text-slate-500 mt-6">
            Belum punya akun? <a href="{{ route('register') }}" class="text-blue-400 hover:underline font-medium">Daftar secara gratis</a>
        </p>
    </div>

</body>
</html>