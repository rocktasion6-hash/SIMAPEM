<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Penting untuk menyimpan role user
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus dikonversi (casted) ke tipe data tertentu.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            // Mengonversi string di database menjadi instance PHP Enum
            'role' => UserRole::class, 
        ];
    }

    /**
     * Relasi ke tabel complaints sebagai pelapor (Warga).
     * Seorang user (Warga) bisa memiliki banyak pengaduan.
     */
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'user_id');
    }

    /**
     * Relasi ke tabel complaints sebagai petugas yang ditugaskan (Pelaksana).
     * Digunakan oleh Kasi untuk melihat beban kerja petugas.
     */
    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Complaint::class, 'assigned_to');
    }

    /**
     * Helper method untuk mengecek role dengan lebih elegan.
     * Contoh penggunaan: if($user->hasRole(UserRole::KADIS))
     */
    public function hasRole(UserRole $role): bool
    {
        return $this->role === $role;
    }
}