<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'code' => 'ITM001',
                'name' => 'Laptop Dell Latitude',
                'description' => 'Laptop for office work',
                'unit' => 'PCS',
                'price' => 12000000,
                'stock' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'ITM002',
                'name' => 'Mouse Wireless Logitech',
                'description' => 'Wireless mouse',
                'unit' => 'PCS',
                'price' => 250000,
                'stock' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'ITM003',
                'name' => 'Keyboard Mechanical',
                'description' => 'Mechanical keyboard RGB',
                'unit' => 'PCS',
                'price' => 850000,
                'stock' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'ITM004',
                'name' => 'Monitor LG 24 inch',
                'description' => 'LED Monitor Full HD',
                'unit' => 'PCS',
                'price' => 2500000,
                'stock' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'ITM005',
                'name' => 'Printer HP LaserJet',
                'description' => 'Laser printer A4',
                'unit' => 'PCS',
                'price' => 3500000,
                'stock' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'ITM006',
                'name' => 'Paper A4 80gsm',
                'description' => 'White paper A4',
                'unit' => 'RIM',
                'price' => 45000,
                'stock' => 0,
                'is_active' => true,
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
