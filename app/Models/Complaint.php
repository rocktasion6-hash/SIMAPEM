<?php

namespace App\Models;

use App\Enums\ComplaintStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_code',
        'user_id',
        'category_id',
        'title',
        'description',
        'photo_path',
        'latitude',
        'longitude',
        'status',
        'assigned_to',
    ];

    /**
     * Konversi otomatis status ke Enum.
     */
    protected function casts(): array
    {
        return [
            'status' => ComplaintStatus::class,
        ];
    }

    /**
     * Relasi ke pelapor (Warga).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke kategori pengaduan.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke petugas yang mengerjakan (Pelaksana).
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Relasi ke riwayat perubahan status dan tanggapan.
     */
    public function histories(): HasMany
    {
        return $this->hasMany(ComplaintHistory::class);
    }
}