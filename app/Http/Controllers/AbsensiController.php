<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    // 1. INDEX (Search + Limit + Filter Kelas + Sort Tanggal)
    public function index(Request $request) {
        // Ambil input (Default sort = desc/terbaru)
        $limit = $request->input('limit', 10);
        $search = $request->input('search');
        $kelas = $request->input('kelas');
        $sort = $request->input('sort', 'desc'); 

        $query = DB::table('attendance_dubes_kehadiran')
            ->join('attendance_dubes_siswa', 'attendance_dubes_kehadiran.id_siswa', '=', 'attendance_dubes_siswa.id_siswa')
            ->select('attendance_dubes_kehadiran.*', 'attendance_dubes_siswa.nama', 'attendance_dubes_siswa.nis', 'attendance_dubes_siswa.id_kelas');

        // Logic Sortir Dinamis
        $query->orderBy('attendance_dubes_kehadiran.tanggal', $sort);

        // Filter Kelas
        if ($kelas) $query->where('attendance_dubes_siswa.id_kelas', $kelas);

        // Filter Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('attendance_dubes_siswa.nama', 'like', "%{$search}%")
                  ->orWhere('attendance_dubes_siswa.nis', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate($limit)->withQueryString();

        return view('absensi.index', [
            'dataAbsensi' => $data, 
            'limit' => $limit,
            'search' => $search,
            'kelasSelected' => $kelas,
            'sort' => $sort // <-- Kita kirim status sort saat ini ('asc' atau 'desc')
        ]);
    }

    // 2. FORM INPUT
    public function create() {
        $siswa = DB::table('attendance_dubes_siswa')->orderBy('nama', 'asc')->get();
        return view('absensi.create', ['siswa' => $siswa]);
    }

    // 3. PROSES SIMPAN ABSENSI (Store)
    public function store(Request $request) {
        $request->validate(['id_siswa'=>'required', 'tanggal'=>'required', 'kehadiran'=>'required']);

        // CEK DUPLIKAT MANUAL
        // "Cari di database, apakah ada data dengan ID Siswa ini DAN Tanggal ini?"
        $cek = DB::table('attendance_dubes_kehadiran')
            ->where('id_siswa', $request->id_siswa)
            ->where('tanggal', $request->tanggal)
            ->exists(); // Hasilnya true/false

        // Jika ketemu (true), tolak!
        if ($cek) {
            // Kembali ke halaman input dengan pesan error
            return back()->with('error', 'Gagal! Siswa tersebut sudah diabsen pada tanggal ini.');
        }

        // Jika lolos, simpan
        DB::table('attendance_dubes_kehadiran')->insert([
            'id_siswa' => $request->id_siswa,
            'tanggal' => $request->tanggal,
            'kehadiran' => $request->kehadiran,
            'created_at' => now(),
        ]);

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil disimpan!');
    }

    // 4. EDIT FORM
    public function edit($id) {
        $data = DB::table('attendance_dubes_kehadiran')->where('id_kehadiran', $id)->first();
        $siswa = DB::table('attendance_dubes_siswa')->where('id_siswa', $data->id_siswa)->first();
        
        return view('absensi.edit', ['d' => $data, 's' => $siswa]);
    }

    // 5. UPDATE
    public function update(Request $request, $id) {
        DB::table('attendance_dubes_kehadiran')->where('id_kehadiran', $id)->update([
            'tanggal' => $request->tanggal,
            'kehadiran' => $request->kehadiran,
            'updated_at' => now(),
        ]);
        return redirect()->route('absensi.index')->with('success', 'Data absensi diperbarui!');
    }

    // 6. DESTROY
    public function destroy($id) {
        DB::table('attendance_dubes_kehadiran')->where('id_kehadiran', $id)->delete();
        return redirect()->route('absensi.index')->with('success', 'Data absensi dihapus!');
    }
}