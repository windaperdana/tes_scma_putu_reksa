<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'code' => 'SUP001',
                'name' => 'PT Supplier Indonesia',
                'address' => 'Jl. Supplier No. 1, Jakarta',
                'phone' => '021-1111111',
                'email' => 'info@supplier1.com',
                'contact_person' => 'John Doe',
                'is_active' => true,
            ],
            [
                'code' => 'SUP002',
                'name' => 'CV Maju Jaya',
                'address' => 'Jl. Maju No. 2, Surabaya',
                'phone' => '031-2222222',
                'email' => 'info@majujaya.com',
                'contact_person' => 'Jane Smith',
                'is_active' => true,
            ],
            [
                'code' => 'SUP003',
                'name' => 'UD Sentosa',
                'address' => 'Jl. Sentosa No. 3, Bandung',
                'phone' => '022-3333333',
                'email' => 'info@sentosa.com',
                'contact_person' => 'Bob Wilson',
                'is_active' => true,
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
