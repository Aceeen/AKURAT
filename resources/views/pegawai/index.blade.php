@extends('layouts.app')

@section('content')
<div class="container-fluid text-white">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Data Pegawai</h1>
        <div class="flex gap-3">
            <button class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-lg text-sm font-semibold flex items-center transition">
                <i class="fas fa-filter mr-2"></i> Filter Pencarian
            </button>
            <button class="btn-primary px-6 py-2.5 rounded-lg text-sm font-bold flex items-center transition">
                <i class="fas fa-plus mr-2"></i> Tambah pegawai baru
            </button>
        </div>
    </div>

    <div class="glass overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-white/10 text-xs uppercase text-blue-100 border-b-2 border-white/20">
                <tr>
                <th class="px-6 py-4 text-left font-bold">NAMA</th>
                <th class="px-6 py-4 text-left font-bold">NIP</th>
                <th class="px-6 py-4 text-left font-bold">JABATAN</th>
                <th class="px-6 py-4 text-left font-bold">GOLONGAN</th>
                <th class="px-6 py-4 text-left font-bold">UNIT KERJA</th>
                <th class="px-6 py-4 text-left font-bold">ROLE</th>
                <th class="px-6 py-4 text-left font-bold">STATUS</th>
                <th class="px-6 py-4 text-center font-bold">AKSI</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @foreach($pegawai as $p)
                <tr class="hover:bg-white/10 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($p->nama) }}&background=0ea5e9&color=fff" class="w-10 h-10 rounded-full mr-3 border-2 border-blue-300/50 shadow-lg">
                            <span class="font-medium text-white">{{ $p->nama }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-blue-200">{{ $p->nip }}</td>
                    <td class="px-6 py-4 text-blue-100">{{ $p->jabatan }}</td>
                    <td class="px-6 py-4 text-blue-100">{{ $p->golongan }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-blue-500/30 text-blue-200 rounded text-[10px] text-xs font-semibold">{{ $p->unitKerja->nama_unit ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-[10px] font-bold uppercase">{{ $p->role }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($p->is_active)
                            <span class="px-3 py-1 bg-green-500/30 text-green-200 rounded-full text-xs font-semibold">Aktif</span>
                        @else
                            <span class="text-red-400 text-[10px] font-bold bg-red-500/10 px-2 py-1 rounded-full border border-red-500/20">Non-Aktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="text-blue-300 hover:text-blue-100 transition">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection