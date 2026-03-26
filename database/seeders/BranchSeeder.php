<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'code' => 'BR001',
                'name' => 'Main Branch',
                'address' => 'Jl. Raya No. 123, Jakarta',
                'phone' => '021-1234567',
                'email' => 'main@company.com',
                'is_active' => true,
            ],
            [
                'code' => 'BR002',
                'name' => 'Surabaya Branch',
                'address' => 'Jl. Raya Surabaya No. 456',
                'phone' => '031-7654321',
                'email' => 'surabaya@company.com',
                'is_active' => true,
            ],
            [
                'code' => 'BR003',
                'name' => 'Bandung Branch',
                'address' => 'Jl. Raya Bandung No. 789',
                'phone' => '022-9876543',
                'email' => 'bandung@company.com',
                'is_active' => true,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
