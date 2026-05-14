<?php

namespace App\Models;

use App\Enums\ComplaintStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplaintHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'user_id',
        'status',
        'notes',
        'action_photo_path',
    ];

    /**
     * Konversi status ke Enum saat log dicatat.
     */
    protected function casts(): array
    {
        return [
            'status' => ComplaintStatus::class,
        ];
    }

    /**
     * Mengetahui pengaduan mana yang sedang di-log.
     */
    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }

    /**
     * Mengetahui siapa petugas yang melakukan update ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}