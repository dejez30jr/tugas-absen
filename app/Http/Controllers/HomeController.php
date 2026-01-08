<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request) {
        // 1. Ambil Tanggal Hari Ini
        $today = now()->format('Y-m-d');
        // (Opsional: Jika ingin tes data lama, ubah $today jadi tanggal manual, misal '2025-10-20')

        // 2. Filter Input
        $limit = $request->input('limit', 10);
        $kelas = $request->input('kelas');
        $search = $request->input('search');

        // 3. Query Data Kehadiran (HANYA HARI INI)
        $query = DB::table('attendance_dubes_kehadiran')
            ->join('attendance_dubes_siswa', 'attendance_dubes_kehadiran.id_siswa', '=', 'attendance_dubes_siswa.id_siswa')
            ->select('attendance_dubes_kehadiran.*', 'attendance_dubes_siswa.nama', 'attendance_dubes_siswa.nis', 'attendance_dubes_siswa.id_kelas')
            ->where('attendance_dubes_kehadiran.tanggal', $today) // Filter Wajib: Hari Ini
            ->orderBy('attendance_dubes_kehadiran.created_at', 'desc');

        // Logic Filter Kelas
        if ($kelas) {
            $query->where('attendance_dubes_siswa.id_kelas', $kelas);
        }

        // Logic Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('attendance_dubes_siswa.nama', 'like', "%{$search}%")
                  ->orWhere('attendance_dubes_siswa.nis', 'like', "%{$search}%");
            });
        }

        // Eksekusi Data
        $data = $query->paginate($limit)->withQueryString();

        // 4. Hitung Statistik Hari Ini (Untuk Bagian Atas seperti Gambar 1)
        $stats = [
            'hadir' => DB::table('attendance_dubes_kehadiran')->where('tanggal', $today)->where('kehadiran', 'Hadir')->count(),
            'terlambat' => DB::table('attendance_dubes_kehadiran')->where('tanggal', $today)->where('kehadiran', 'Terlambat')->count(),
        ];

        return view('welcome', [
            'data' => $data,
            'stats' => $stats,
            'limit' => $limit,
            'kelasSelected' => $kelas,
            'search' => $search
        ]);
    }
}