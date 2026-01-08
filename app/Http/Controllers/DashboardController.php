<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request) {
        // 1. Filter Limit, Kelas, dan Search
        $limit = $request->input('limit', 10);
        $kelas = $request->input('kelas');
        $search = $request->input('search');

        // 2. Query Data Absensi
        $query = DB::table('attendance_dubes_kehadiran')
            ->join('attendance_dubes_siswa', 'attendance_dubes_kehadiran.id_siswa', '=', 'attendance_dubes_siswa.id_siswa')
            ->select('attendance_dubes_kehadiran.*', 'attendance_dubes_siswa.nama', 'attendance_dubes_siswa.nis', 'attendance_dubes_siswa.id_kelas')
            ->orderBy('attendance_dubes_kehadiran.tanggal', 'desc')
            ->orderBy('attendance_dubes_kehadiran.created_at', 'desc');

        // Logic Filter Kelas
        if ($kelas) {
            $query->where('attendance_dubes_siswa.id_kelas', $kelas);
        }

        // Logic Search (Cari Nama atau NIS)
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('attendance_dubes_siswa.nama', 'like', "%{$search}%")
                  ->orWhere('attendance_dubes_siswa.nis', 'like', "%{$search}%");
            });
        }

        // Eksekusi Pagination
        $data = $query->paginate($limit)->withQueryString();

        // 3. HITUNG STATISTIK HARI INI
        $today = now()->format('Y-m-d');
        
        $stats = [
            'hadir' => DB::table('attendance_dubes_kehadiran')->where('tanggal', $today)->where('kehadiran', 'Hadir')->count(),
            'terlambat' => DB::table('attendance_dubes_kehadiran')->where('tanggal', $today)->where('kehadiran', 'Terlambat')->count(),
            'lainnya' => DB::table('attendance_dubes_kehadiran')->where('tanggal', $today)->whereIn('kehadiran', ['Sakit', 'Izin', 'Alpha'])->count(),
        ];

        return view('dashboard', [
            'data' => $data,
            'limit' => $limit,
            'kelasSelected' => $kelas,
            'search' => $search,
            'stats' => $stats // Kirim data statistik
        ]);
    }
}