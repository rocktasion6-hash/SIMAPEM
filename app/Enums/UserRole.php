<?php

namespace App\Enums;

enum UserRole: string
{
    case WARGA = 'warga';
    case FRONT_OFFICE = 'front_office';
    case KASI = 'kasi';
    case PELAKSANA = 'pelaksana';
    case KADIS = 'kadis';
}