<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. TABEL AKUN (Role & Rule sudah diperbaiki jadi 'role')
        Schema::create('attendance_dubes_account', function (Blueprint $table) {
            $table->id('id_users');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('admin'); // Kolom Role
            $table->timestamps();
        });

        // 2. TABEL SISWA
        Schema::create('attendance_dubes_siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->string('nis')->unique();
            $table->string('nama');
            $table->string('id_kelas');
            $table->string('gender');
            $table->timestamps();
        });

        // 3. TABEL KEHADIRAN
        Schema::create('attendance_dubes_kehadiran', function (Blueprint $table) {
            $table->id('id_kehadiran');
            $table->unsignedBigInteger('id_siswa');
            $table->date('tanggal');
            $table->enum('kehadiran', ['Hadir', 'Terlambat', 'Sakit', 'Izin', 'Alpha']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_dubes_account');
        Schema::dropIfExists('attendance_dubes_siswa');
        Schema::dropIfExists('attendance_dubes_kehadiran');
    }
};