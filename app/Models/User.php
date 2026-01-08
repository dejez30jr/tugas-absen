<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Arahkan ke tabel soal
    protected $table = 'attendance_dubes_account';
    protected $primaryKey = 'id_users';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role', // Pastikan ini role
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}