@extends('layouts.app')

@section('title', 'Profile Saya')
@section('subtitle', 'Kelola informasi akun dan identitas pengguna kamu')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 text-base mb-1">Informasi Akun</h3>
        <p class="text-xs text-slate-400 mb-6">Detail profil kamu di aplikasi SIPINJAM</p>

        <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('patch')

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">NAMA LENGKAP</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">EMAIL</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">NIS / NIP</label>
                <input type="text" value="{{ $user->nis_nip ?? '-' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-100 bg-slate-50 text-xs text-slate-500 cursor-not-allowed" readonly>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">PERAN / ROLE</label>
                <input type="text" value="{{ ucfirst($user->role) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-100 bg-slate-50 text-xs text-slate-500 cursor-not-allowed" readonly>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2 rounded-xl bg-[#182235] text-white text-xs font-bold uppercase hover:bg-slate-800 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection