<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PurchaseReceipt;
use App\Models\PurchaseReceiptDetail;
use App\Models\Item;

class PurchaseReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // PB 1
        $pb1 = PurchaseReceipt::create([
            'pb_number' => 'PB/2026/03/001',
            'purchase_order_id' => 1,
            'receipt_date' => '2026-03-26',
            'status' => 'completed',
            'notes' => 'All items received',
        ]);

        PurchaseReceiptDetail::create([
            'purchase_receipt_id' => $pb1->id,
            'item_id' => 1,
            'quantity_received' => 5,
            'price' => 12000000,
        ]);

        PurchaseReceiptDetail::create([
            'purchase_receipt_id' => $pb1->id,
            'item_id' => 2,
            'quantity_received' => 5,
            'price' => 250000,
        ]);

        PurchaseReceiptDetail::create([
            'purchase_receipt_id' => $pb1->id,
            'item_id' => 3,
            'quantity_received' => 5,
            'price' => 850000,
        ]);

        // Update stock
        Item::find(1)->increment('stock', 5);
        Item::find(2)->increment('stock', 5);
        Item::find(3)->increment('stock', 5);
    }
}
