<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIPINJAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-[#111827] min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-3xl p-8 shadow-2xl border border-slate-100">
        <div class="text-center mb-8">
            <div class="w-12 h-12 bg-gradient-to-tr from-teal-500 to-emerald-400 rounded-2xl mx-auto flex items-center justify-center font-extrabold text-white text-2xl shadow-lg shadow-teal-500/30 mb-3">
                S
            </div>
            <h2 class="text-2xl font-extrabold text-slate-800">SIPINJAM</h2>
            <p class="text-xs text-slate-400 mt-1">Masuk menggunakan NIS / NIP kamu</p>
        </div>

        @if (session('status'))
            <div class="mb-5 p-4 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-2xl text-xs font-semibold flex items-center space-x-2">
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-2">NIS / NIP *</label>
                <input type="text" name="nis_nip" value="{{ old('nis_nip') }}" placeholder="Masukkan NIS atau NIP" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required autofocus />
                @error('nis_nip')
                    <span class="text-rose-500 text-xs mt-1 block font-semibold">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Password *</label>
                <input type="password" name="password" placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required />
                @error('password')
                    <span class="text-rose-500 text-xs mt-1 block font-semibold">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center space-x-2 text-slate-500 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 bg-[#111827] hover:bg-slate-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-md">
                Masuk Sistem
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 text-center text-xs text-slate-500">
            Belum punya akun siswa? 
            <a href="{{ route('register') }}" class="font-bold text-teal-600 hover:text-teal-700">Daftar Akun Baru</a>
        </div>
    </div>
</body>
</html>