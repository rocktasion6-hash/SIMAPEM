<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Infrastruktur', 'slug' => 'infrastruktur'],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan'],
            ['name' => 'Kebersihan & Lingkungan', 'slug' => 'kebersihan-lingkungan'],
            ['name' => 'Keamanan', 'slug' => 'keamanan'],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}