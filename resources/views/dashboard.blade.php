@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-8 text-white">Dashboard</h1>

<!-- Statistik Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <div class="glass-strong p-6 text-center hover:scale-105 transition-transform">
        <p class="text-blue-100 text-xs mb-2 uppercase tracking-wider font-semibold">Total Pegawai</p>
        <h2 class="text-5xl font-bold text-white mb-1">{{ $totalPegawai }}</h2>
        <div class="w-12 h-1 bg-blue-400/50 mx-auto mt-3 rounded-full"></div>
    </div>
    <div class="glass-strong p-6 text-center hover:scale-105 transition-transform">
        <p class="text-blue-100 text-xs mb-2 uppercase tracking-wider font-semibold">Progress Unggah Berkas</p>
        <h2 class="text-5xl font-bold text-white mb-1">{{ $progressUpload }}%</h2>
        <div class="w-12 h-1 bg-blue-400/50 mx-auto mt-3 rounded-full"></div>
    </div>
    <div class="glass-strong p-6 text-center hover:scale-105 transition-transform">
        <p class="text-blue-100 text-xs mb-2 uppercase tracking-wider font-semibold">Rata-rata Skor Kinerja</p>
        <h2 class="text-5xl font-bold text-white mb-1">{{ $rataRataDinas }}</h2>
        <div class="w-12 h-1 bg-blue-400/50 mx-auto mt-3 rounded-full"></div>
    </div>
    <div class="glass-strong p-6 text-center border-l-4 border-red-400 hover:scale-105 transition-transform">
        <p class="text-blue-100 text-xs mb-2 uppercase tracking-wider font-semibold">Berkas Belum Dinilai</p>
        <h2 class="text-5xl font-bold text-red-200 bg-red-600/30 rounded-lg inline-block px-5 py-2 mb-1">
            {{ $berkasBelumDinilai }}
        </h2>
        <div class="w-12 h-1 bg-red-400/50 mx-auto mt-3 rounded-full"></div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    <div class="glass-strong p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-white text-lg">Performa rata-rata per Bidang</h3>
            <button class="text-[10px] bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg uppercase font-bold transition">
                View Report
            </button>
        </div>
        <canvas id="barChart" height="200"></canvas>
    </div>
    <div class="glass-strong p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-white text-lg">Komposisi Predikat</h3>
            <p class="text-xs text-blue-100 font-semibold">From 2020-2021</p>
        </div>
        <div class="flex items-center justify-center">
            <div class="relative" style="width: 200px; height: 200px;">
                <canvas id="donutChart"></canvas>
            </div>
            <div class="ml-8 space-y-3">
                <div class="flex items-center">
                    <span class="w-4 h-4 rounded-full bg-blue-400 mr-3 shadow-lg"></span>
                    <span class="text-sm text-blue-50">Baik <span class="font-bold">38%</span></span>
                </div>
                <div class="flex items-center">
                    <span class="w-4 h-4 rounded-full bg-blue-300 mr-3 shadow-lg"></span>
                    <span class="text-sm text-blue-50">Sangat Baik <span class="font-bold">16%</span></span>
                </div>
                <div class="flex items-center">
                    <span class="w-4 h-4 rounded-full bg-blue-200 mr-3 shadow-lg"></span>
                    <span class="text-sm text-blue-50">Buruk <span class="font-bold">9%</span></span>
                </div>
                <div class="flex items-center">
                    <span class="w-4 h-4 rounded-full bg-blue-100 mr-3 shadow-lg"></span>
                    <span class="text-sm text-blue-50">Sangat Buruk <span class="font-bold">30%</span></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tables Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="glass-card overflow-hidden">
        <div class="p-5 border-b border-white/20 bg-white/5">
            <h3 class="text-center font-bold text-white">5 Performa Teratas</h3>
        </div>
        <table class="w-full text-sm text-left">
            <thead class="bg-white/10 text-xs uppercase text-blue-100 border-b border-white/10">
                <tr>
                    <th class="px-6 py-4 font-bold">No</th>
                    <th class="px-6 py-4 text-left font-bold">Nama</th>
                    <th class="px-6 py-4 text-left font-bold">NIP</th>
                    <th class="px-6 py-4 text-left font-bold">Skor Kinerja</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @for($i=1; $i<=5; $i++)
                <tr class="hover:bg-white/10 transition">
                    <td class="px-6 py-4 text-blue-100 font-semibold">{{ $i }}</td>
                    <td class="px-6 py-4 font-medium text-white">Pegawai Terbaik {{ $i }}</td>
                    <td class="px-6 py-4 text-blue-200">1980010100{{ $i }}</td>
                    <td class="px-6 py-4 font-bold text-green-300 text-base">95.5</td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <div class="glass-card overflow-hidden">
        <div class="p-5 border-b border-white/20 bg-white/5 text-center">
            <h3 class="font-bold text-white text-lg">5 Performa Terendah</h3>
        </div>
        <table class="w-full text-sm text-left">
            <thead class="bg-white/10 text-xs uppercase text-blue-100 border-b border-white/10">
                <tr>
                    <th class="px-6 py-4 font-bold">No</th>
                    <th class="px-6 py-4 text-left font-bold">Nama</th>
                    <th class="px-6 py-4 text-left font-bold">NIP</th>
                    <th class="px-6 py-4 text-left font-bold">Skor Kinerja</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @for($i=1; $i<=5; $i++)
                <tr class="hover:bg-white/10 transition">
                    <td class="px-6 py-4 text-blue-100 font-semibold">{{ $i }}</td>
                    <td class="px-6 py-4 font-medium text-white">Pegawai Kurang {{ $i }}</td>
                    <td class="px-6 py-4 text-blue-200">1985010100{{ $i }}</td>
                    <td class="px-6 py-4 font-bold text-red-300 text-base">45.0</td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Bar Chart dengan warna biru
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Bidang A', 'Bidang B', 'Bidang C'],
            datasets: [{
                label: 'Performa %',
                data: [65, 45, 60],
                backgroundColor: 'rgba(96, 165, 250, 0.8)',
                borderRadius: 8,
                borderWidth: 0
            }]
        },
        options: {
            scales: { 
                y: { 
                    beginAtZero: true, 
                    grid: { color: 'rgba(147, 197, 253, 0.1)' }, 
                    ticks: { color: '#bfdbfe' } 
                }, 
                x: { 
                    grid: { display: false },
                    ticks: { color: '#bfdbfe' } 
                } 
            },
            plugins: { 
                legend: { display: false } 
            }
        }
    });

    // Donut Chart dengan warna biru
    new Chart(document.getElementById('donutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Baik', 'Sangat Baik', 'Buruk', 'Sangat Buruk'],
            datasets: [{
                data: [38, 16, 9, 30],
                backgroundColor: ['#60a5fa', '#93c5fd', '#bfdbfe', '#dbeafe'],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '70%',
            plugins: { 
                legend: { display: false } 
            }
        }
    });
</script>
@endpush
