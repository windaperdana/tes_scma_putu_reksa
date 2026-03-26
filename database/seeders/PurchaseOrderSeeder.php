<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // PO 1
        $po1 = PurchaseOrder::create([
            'po_number' => 'PO/2026/03/001',
            'purchase_request_id' => 1,
            'supplier_id' => 1,
            'order_date' => '2026-03-21',
            'expected_date' => '2026-03-28',
            'total_amount' => 65500000,
            'status' => 'approved',
            'notes' => 'IT Equipment Order',
        ]);

        PurchaseOrderDetail::create([
            'purchase_order_id' => $po1->id,
            'item_id' => 1,
            'quantity' => 5,
            'price' => 12000000,
            'subtotal' => 60000000,
        ]);

        PurchaseOrderDetail::create([
            'purchase_order_id' => $po1->id,
            'item_id' => 2,
            'quantity' => 5,
            'price' => 250000,
            'subtotal' => 1250000,
        ]);

        PurchaseOrderDetail::create([
            'purchase_order_id' => $po1->id,
            'item_id' => 3,
            'quantity' => 5,
            'price' => 850000,
            'subtotal' => 4250000,
        ]);

        // PO 2
        $po2 = PurchaseOrder::create([
            'po_number' => 'PO/2026/03/002',
            'purchase_request_id' => 2,
            'supplier_id' => 2,
            'order_date' => '2026-03-23',
            'expected_date' => '2026-03-30',
            'total_amount' => 9250000,
            'status' => 'approved',
            'notes' => 'Office supplies order',
        ]);

        PurchaseOrderDetail::create([
            'purchase_order_id' => $po2->id,
            'item_id' => 6,
            'quantity' => 50,
            'price' => 45000,
            'subtotal' => 2250000,
        ]);

        PurchaseOrderDetail::create([
            'purchase_order_id' => $po2->id,
            'item_id' => 5,
            'quantity' => 2,
            'price' => 3500000,
            'subtotal' => 7000000,
        ]);
    }
}
