<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Siswa - SIPINJAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-[#111827] min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-3xl p-8 shadow-2xl border border-slate-100">
        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-gradient-to-tr from-teal-500 to-emerald-400 rounded-2xl mx-auto flex items-center justify-center font-extrabold text-white text-2xl shadow-lg shadow-teal-500/30 mb-3">
                S
            </div>
            <h2 class="text-2xl font-extrabold text-slate-800">Daftar Akun Siswa</h2>
            <p class="text-xs text-slate-400 mt-1">Isi formulir untuk membuat akun peminjaman baru</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">NIS (Nomor Induk Siswa) *</label>
                <input type="text" name="nis_nip" value="{{ old('nis_nip') }}" placeholder="Contoh: 220013" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required autofocus />
                @error('nis_nip')
                    <span class="text-rose-500 text-xs mt-1 block font-semibold">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nama Lengkap *</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama siswa" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required />
                @error('name')
                    <span class="text-rose-500 text-xs mt-1 block font-semibold">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@siswa.sch.id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required />
                @error('email')
                    <span class="text-rose-500 text-xs mt-1 block font-semibold">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Password *</label>
                <input type="password" name="password" placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required />
                @error('password')
                    <span class="text-rose-500 text-xs mt-1 block font-semibold">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Konfirmasi Password *</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required />
            </div>

            <button type="submit" class="w-full py-3 bg-[#111827] hover:bg-slate-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-md mt-2">
                Daftar Akun Siswa
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-500">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="font-bold text-teal-600 hover:text-teal-700">Masuk di sini</a>
        </div>
    </div>
</body>
</html>