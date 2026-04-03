<?php

namespace App\Services;

use App\Models\User;
use App\Models\KriteriaTupoksi;
use App\Models\Penilaian;
use Illuminate\Support\Facades\DB;

class PerformanceService
{
    public function hitungNilaiTriwulan(User $user, $triwulan, $tahun)
    {
        // 1. Ambil semua kriteria yang aktif untuk triwulan tersebut
        $kriteria = KriteriaTupoksi::whereHas('tupoksi', function($q) use ($user, $tahun) {
            $q->where('user_id', $user->id)->where('tahun', $tahun);
        })->where('t'.$triwulan, true)->get();

        $totalKriteria = $kriteria->count();
        if ($totalKriteria === 0) return 0;

        $skorDiperoleh = 0;

        /**
         * LOGIKA BARU:
         * Kita langsung mencari skor di tabel 'penilaian' berdasarkan kriteria_id.
         * Tidak lagi mencari lewat tabel berkas_kinerja.
         */
        foreach ($kriteria as $item) {
            $penilaian = Penilaian::where('kriteria_id', $item->id)
                ->where('user_id', $user->id)
                ->where('triwulan', $triwulan)
                ->where('tahun', $tahun)
                ->first();

            if ($penilaian) {
                $skorDiperoleh += (int) $penilaian->skor;
            }
        }

        // Rumus: (Total Skor / (Total Kriteria * 3)) * 100
        $nilai = ($skorDiperoleh / ($totalKriteria * 3)) * 100;
        return round($nilai, 2);
    }

    public function hitungNilaiTahunan(User $user, $tahun)
    {
        $t1 = $this->hitungNilaiTriwulan($user, 1, $tahun);
        $t2 = $this->hitungNilaiTriwulan($user, 2, $tahun);
        $t3 = $this->hitungNilaiTriwulan($user, 3, $tahun);
        $t4 = $this->hitungNilaiTriwulan($user, 4, $tahun);

        $rataRata = ($t1 + $t2 + $t3 + $t4) / 4;
        return round($rataRata, 2);
    }

    public function getPredikat($skor)
    {
        // Ambil ambang batas dari settings agar dinamis
        $sangatBaik = DB::table('settings')->where('key', 'skor_sangat_baik')->value('value') ?? 81;
        $baik = DB::table('settings')->where('key', 'skor_baik')->value('value') ?? 70;
        $cukup = DB::table('settings')->where('key', 'skor_cukup')->value('value') ?? 0;

        if ($skor >= $sangatBaik) return "Sangat Baik";
        if ($skor >= $baik) return "Baik";
        if ($skor >= $cukup) return "Cukup";
        
        return "Kurang / Tidak Memenuhi";
    }
}