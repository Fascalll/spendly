<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'expense' => [
                'Makan & Minum',
                'Transportasi',
                'Belanja',
                'Tagihan',
                'Hiburan',
                'Kesehatan',
                'Pendidikan',
                'Kos & Tempat Tinggal',
                'Lainnya',
            ],
            'income' => [
                'Gaji',
                'Freelance',
                'Bisnis',
                'Uang Saku',
                'Hadiah',
                'Investasi',
                'Lainnya',
            ],
        ];

        foreach ($categories as $type => $names) {
            foreach ($names as $name) {
                Category::firstOrCreate([
                    'user_id' => null,
                    'name' => $name,
                    'type' => $type,
                ]);
            }
        }
    }
}

