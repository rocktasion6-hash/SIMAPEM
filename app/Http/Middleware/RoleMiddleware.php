<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Menangani permintaan masuk.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Daftar role yang diizinkan (dikirim dari route)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Pastikan user sudah terautentikasi (login)
        if (! $request->user()) {
            return redirect()->route('login');
        }

        /** 
         * 2. Periksa apakah value dari Enum role user ada dalam array $roles.
         * Kita menggunakan $request->user()->role->value karena role kita 
         * dikonversi (casted) ke PHP Enum di Model User.
         */
        if (! in_array($request->user()->role->value, $roles)) {
            // Jika tidak memiliki akses, tampilkan error 403 (Forbidden)
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}