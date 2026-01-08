<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // WAJIB: Untuk enkripsi password

class PenggunaController extends Controller
{
    // 1. INDEX (List Pengguna)
    public function index() {
        $users = DB::table('attendance_dubes_account')->orderBy('id_users', 'desc')->get();
        return view('pengguna.index', ['users' => $users]);
    }

    // 2. CREATE (Form Tambah)
    public function create() {
        return view('pengguna.create');
    }

    // 3. STORE (Simpan Data)
    public function store(Request $request) {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:attendance_dubes_account,email', // Email tidak boleh kembar
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        DB::table('attendance_dubes_account')->insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi Password
            'role' => $request->role,
            'created_at' => now(),
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    // 4. EDIT (Form Edit)
    public function edit($id) {
        $user = DB::table('attendance_dubes_account')->where('id_users', $id)->first();
        return view('pengguna.edit', ['user' => $user]);
    }

    // 5. UPDATE (Simpan Perubahan)
    public function update(Request $request, $id) {
        // Cek apakah user mau ganti password?
        if ($request->password) {
            $data = [
                'nama' => $request->nama,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password), // Update Password Baru
                'updated_at' => now(),
            ];
        } else {
            // Jika kolom password kosong, jangan ubah password lama
            $data = [
                'nama' => $request->nama,
                'email' => $request->email,
                'role' => $request->role,
                'updated_at' => now(),
            ];
        }

        DB::table('attendance_dubes_account')->where('id_users', $id)->update($data);

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna diperbarui!');
    }

    // 6. DESTROY (Hapus)
    public function destroy($id) {
        DB::table('attendance_dubes_account')->where('id_users', $id)->delete();
        return redirect()->route('pengguna.index')->with('success', 'Pengguna dihapus!');
    }
}