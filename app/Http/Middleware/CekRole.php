<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    // Fungsi untuk mengecek Role
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Jika role user saat ini TIDAK SAMA dengan yang diminta
        if ($request->user()->role !== $role) {
            // Tendang / Tampilkan Error 403 (Forbidden)
            abort(403, 'Akses Ditolak! Anda bukan Admin.');
        }

        return $next($request);
    }
}