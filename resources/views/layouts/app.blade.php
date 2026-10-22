<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPINJAM - Inventaris & Peminjaman Sekolah</title>
    <!-- Favicon Browser -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50/50 text-slate-800 antialiased min-h-screen flex">

    <!-- Sidebar Navy Dark -->
    <aside class="w-64 bg-[#111827] text-slate-300 flex flex-col justify-between min-h-screen fixed left-0 top-0 z-30 shadow-xl border-r border-slate-800/60">
        <div>
            <!-- Logo Sidebar -->
            <div class="px-6 py-6 flex items-center space-x-3 border-b border-slate-800/80">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SIPINJAM" class="w-9 h-9 object-contain rounded-xl">
                <div>
                    <h1 class="font-extrabold text-white text-base tracking-wider leading-none">SIPINJAM</h1>
                    <span class="text-[11px] text-teal-400 font-medium">Inventaris Sekolah</span>
                </div>
            </div>

            <!-- Navigasi Menu Sesuai Role -->
            <nav class="px-4 mt-6 space-y-1.5">
                <!-- Menu Umum: Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-teal-500/10 text-teal-400 border border-teal-500/20' : 'hover:bg-slate-800/60 text-slate-400 hover:text-slate-200' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>Dashboard</span>
                </a>

                @if(Auth::user()->role === 'siswa')
                    <!-- Menu Khusus SISWA -->
                    <a href="{{ route('borrowing.create') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('borrowing.create') ? 'bg-teal-500/10 text-teal-400 border border-teal-500/20' : 'hover:bg-slate-800/60 text-slate-400 hover:text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Ajukan Peminjaman</span>
                    </a>

                    <a href="{{ route('borrowing.history') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('borrowing.history') ? 'bg-teal-500/10 text-teal-400 border border-teal-500/20' : 'hover:bg-slate-800/60 text-slate-400 hover:text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Riwayat Saya</span>
                    </a>
                @endif

                @if(Auth::user()->role === 'petugas')
                    <!-- Menu Khusus PETUGAS / ADMIN -->
                    <a href="{{ route('borrowing.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('borrowing.index') ? 'bg-teal-500/10 text-teal-400 border border-teal-500/20' : 'hover:bg-slate-800/60 text-slate-400 hover:text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <span>Kelola Peminjaman</span>
                    </a>

                    <a href="{{ route('inventaris.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('inventaris.*') ? 'bg-teal-500/10 text-teal-400 border border-teal-500/20' : 'hover:bg-slate-800/60 text-slate-400 hover:text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <span>Data Inventaris</span>
                    </a>

                    <a href="{{ route('borrowing.report') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('borrowing.report') ? 'bg-teal-500/10 text-teal-400 border border-teal-500/20' : 'hover:bg-slate-800/60 text-slate-400 hover:text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        <span>Laporan Peminjaman</span>
                    </a>
                @endif

                <!-- Menu Umum: Profile -->
                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('profile.*') ? 'bg-teal-500/10 text-teal-400 border border-teal-500/20' : 'hover:bg-slate-800/60 text-slate-400 hover:text-slate-200' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Profile Saya</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer Profile -->
        <div class="p-4 border-t border-slate-800/80 bg-slate-900/50 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-teal-500 to-emerald-500 text-white flex items-center justify-center font-bold text-xs shadow-md">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div>
                    <p class="text-xs font-bold text-white leading-tight truncate max-w-[110px]">{{ Auth::user()->name }}</p>
                    <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[9px] font-extrabold uppercase {{ Auth::user()->role === 'petugas' ? 'bg-teal-500/20 text-teal-400' : 'bg-indigo-500/20 text-indigo-400' }}">
                        {{ Auth::user()->role === 'petugas' ? 'Petugas' : 'Siswa' }}
                    </span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="p-2 text-slate-400 hover:text-rose-400 rounded-lg hover:bg-slate-800 transition" title="Logout">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 ml-64 flex flex-col min-h-screen">
        <header class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 px-8 py-4 flex items-center justify-between sticky top-0 z-20">
            <div>
                <h2 class="text-lg font-bold text-slate-800">@yield('title', 'Dashboard')</h2>
                <p class="text-xs text-slate-400">@yield('subtitle', 'Sistem Pengelolaan Inventaris Sekolah')</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="px-3 py-1.5 rounded-full bg-slate-100 border border-slate-200/80 text-[11px] font-semibold text-slate-600 flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Sistem Aktif</span>
                </div>
            </div>
        </header>

        <main class="p-8 flex-1">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200/80 text-emerald-800 rounded-2xl text-xs font-semibold flex items-center space-x-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200/80 text-rose-800 rounded-2xl text-xs font-semibold flex items-center space-x-3 shadow-sm">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>