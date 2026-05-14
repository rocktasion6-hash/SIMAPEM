<?php

namespace App\Enums;

enum ComplaintStatus: string
{
    case PENDING = 'pending';           // Baru masuk dari warga
    case VERIFIED = 'verified';         // Diverifikasi & dikategorikan oleh FO
    case ASSIGNED = 'assigned';         // Diteruskan ke pelaksana oleh Kasi
    case IN_PROGRESS = 'in_progress';   // Sedang dikerjakan pelaksana
    case RESOLVED = 'resolved';         // Selesai dikerjakan
    case REJECTED = 'rejected';         // Ditolak (misal: laporan palsu/tidak valid)
}