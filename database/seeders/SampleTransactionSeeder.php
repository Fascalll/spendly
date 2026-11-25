<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SampleTransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Development-only demo account.
        $user = User::firstOrCreate(
            ['email' => 'demo@spendly.local'],
            [
                'name' => 'Spendly Demo',
                'password' => Hash::make('password'),
            ]
        );

        $samples = [
            [
                'type' => 'income',
                'category' => 'Gaji',
                'amount' => 5000000,
                'days_ago' => 25,
                'description' => 'Gaji bulanan',
            ],
            [
                'type' => 'income',
                'category' => 'Freelance',
                'amount' => 750000,
                'days_ago' => 18,
                'description' => 'Project desain freelance',
            ],
            [
                'type' => 'income',
                'category' => 'Uang Saku',
                'amount' => 500000,
                'days_ago' => 12,
                'description' => 'Uang saku bulanan',
            ],
            [
                'type' => 'expense',
                'category' => 'Kos & Tempat Tinggal',
                'amount' => 1200000,
                'days_ago' => 24,
                'description' => 'Bayar kos bulan ini',
            ],
            [
                'type' => 'expense',
                'category' => 'Makan & Minum',
                'amount' => 25000,
                'days_ago' => 1,
                'description' => 'Makan siang',
            ],
            [
                'type' => 'expense',
                'category' => 'Makan & Minum',
                'amount' => 18000,
                'days_ago' => 2,
                'description' => 'Kopi Kenangan',
            ],
            [
                'type' => 'expense',
                'category' => 'Transportasi',
                'amount' => 22000,
                'days_ago' => 3,
                'description' => 'Gojek ke kampus',
            ],
            [
                'type' => 'expense',
                'category' => 'Transportasi',
                'amount' => 15000,
                'days_ago' => 4,
                'description' => 'Grab pulang',
            ],
            [
                'type' => 'expense',
                'category' => 'Belanja',
                'amount' => 85000,
                'days_ago' => 5,
                'description' => 'Belanja di Indomaret',
            ],
            [
                'type' => 'expense',
                'category' => 'Tagihan',
                'amount' => 100000,
                'days_ago' => 6,
                'description' => 'Bayar pulsa',
            ],
            [
                'type' => 'expense',
                'category' => 'Hiburan',
                'amount' => 50000,
                'days_ago' => 8,
                'description' => 'Nonton bioskop',
            ],
            [
                'type' => 'expense',
                'category' => 'Kesehatan',
                'amount' => 35000,
                'days_ago' => 10,
                'description' => 'Beli obat di apotek',
            ],
            [
                'type' => 'expense',
                'category' => 'Pendidikan',
                'amount' => 45000,
                'days_ago' => 11,
                'description' => 'Print tugas kuliah',
            ],
            [
                'type' => 'expense',
                'category' => 'Makan & Minum',
                'amount' => 32000,
                'days_ago' => 13,
                'description' => 'Makan malam',
            ],
            [
                'type' => 'expense',
                'category' => 'Belanja',
                'amount' => 120000,
                'days_ago' => 15,
                'description' => 'Beli kebutuhan bulanan',
            ],
        ];

        foreach ($samples as $sample) {
            $category = Category::whereNull('user_id')
                ->where('type', $sample['type'])
                ->where('name', $sample['category'])
                ->firstOrFail();

            $date = now()->subDays($sample['days_ago'])->toDateString();

            Transaction::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'type' => $sample['type'],
                    'amount' => $sample['amount'],
                    'date' => $date,
                    'description' => $sample['description'],
                ]
            );
        }
    }
}

