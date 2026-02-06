@extends('layouts.app')

@section('content')
<div class="container-fluid text-white">
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight">Tugas & Unggah Berkas</h1>
        <p class="text-blue-200 text-sm opacity-80 mt-1">Lengkapi bukti dukung kinerja untuk <span class="font-bold text-white uppercase">Triwulan {{ DB::table('settings')->where('key', 'triwulan_aktif')->value('value') }}</span></p>
    </div>

    @forelse($tupoksis as $tupoksi)
    <div class="glass-strong mb-8 overflow-hidden">
        <div class="p-5 bg-white/10 flex items-center border-b border-white/20">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-4 shadow-lg text-white">
                <i class="fas fa-briefcase"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-white">{{ $tupoksi->nama_tupoksi }}</h3>
                <p class="text-[10px] text-blue-200 uppercase tracking-widest">Butir Kegiatan Utama</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-black/20 text-[10px] uppercase text-blue-200 font-bold">
                    <tr>
                        <th class="px-6 py-4 text-left">Rincian Kriteria Penilaian</th>
                        <th class="px-6 py-4 text-center">Status Berkas</th>
                        <th class="px-6 py-4 text-center">Nilai Atasan</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($tupoksi->kriteria as $kriteria)
                    <tr class="hover:bg-white/5 transition-all">
                        <td class="px-6 py-4">
                            <div class="font-bold text-white">{{ $kriteria->nama_kriteria }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php $berkas = $kriteria->berkasKinerja->first(); @endphp
                            @if($berkas)
                                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-full text-[10px] font-bold uppercase">Terunggah</span>
                            @else
                                <span class="px-3 py-1 bg-red-500/20 text-red-300 border border-red-500/30 rounded-full text-[10px] font-bold uppercase">Belum Ada</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($berkas && $berkas->penilaian)
                                <span class="text-xl font-black text-blue-300">{{ $berkas->penilaian->skor }}</span>
                            @else
                                <span class="text-white/20 italic text-[10px]">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if(!$berkas)
                                <button onclick="openModalUpload('{{ $kriteria->id }}', '{{ addslashes($kriteria->nama_kriteria) }}')" 
                                    class="bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded-lg text-[10px] font-bold uppercase transition-all shadow-lg text-white">
                                    Unggah Bukti
                                </button>
                            @else
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('kinerja.berkas.download', $berkas->id) }}" class="p-2 bg-white/10 hover:bg-white/20 rounded-lg text-blue-300 transition" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(!$berkas->penilaian)
                                    <form action="{{ route('kinerja.berkas.destroy', $berkas->id) }}" method="POST" onsubmit="return confirm('Hapus berkas?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white rounded-lg transition">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-4 text-center text-white/20 italic">Tidak ada kriteria.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <div class="glass-strong p-20 text-center">
        <h4 class="text-white/50 font-bold">Tupoksi Belum Diatur</h4>
    </div>
    @endforelse
</div>

<!-- Modal Upload Berkas -->
<div id="modalUpload" class="fixed inset-0 bg-black/80 backdrop-blur-md hidden z-[100] items-center justify-center p-4">
    <div class="glass-strong w-full max-w-md p-8 border border-white/30 text-left">
        <h3 class="text-xl font-bold text-white mb-1">Unggah Bukti Dukung</h3>
        <p id="label_kriteria" class="text-[10px] text-blue-300 italic mb-6 font-medium uppercase"></p>

        <form action="{{ route('kinerja.upload.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="kriteria_id" id="modal_kriteria_id">
            <input type="hidden" name="triwulan" value="{{ DB::table('settings')->where('key', 'triwulan_aktif')->value('value') }}">
            
            <div class="space-y-6">
                <div class="border-2 border-dashed border-white/20 rounded-2xl p-8 text-center bg-black/20">
                    <input type="file" name="file_bukti" id="file_bukti" class="hidden" accept=".pdf,.jpg,.jpeg,.png" required onchange="document.getElementById('display_name').innerText = this.files[0].name">
                    <label for="file_bukti" class="cursor-pointer">
                        <i class="fas fa-cloud-upload-alt fa-3x text-blue-400 mb-3"></i>
                        <p class="text-sm font-medium text-white" id="display_name">Klik untuk pilih file</p>
                        <p class="text-[10px] text-white/40 mt-1 uppercase">PDF/Gambar Max 5MB</p>
                    </label>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 py-4 rounded-xl font-black text-xs text-white uppercase tracking-widest shadow-lg transition-all">Kirim Berkas</button>
                <button type="button" onclick="closeModalUpload()" class="w-full text-white/40 text-xs font-bold uppercase tracking-widest mt-2 hover:text-white transition">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalUpload(id, nama) {
        document.getElementById('modal_kriteria_id').value = id;
        document.getElementById('label_kriteria').innerText = "Kriteria: " + nama;
        const m = document.getElementById('modalUpload');
        m.classList.remove('hidden');
        m.classList.add('flex');
    }
    function closeModalUpload() {
        const m = document.getElementById('modalUpload');
        m.classList.add('hidden');
        m.classList.remove('flex');
    }
</script>
@endsection