<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestDetail;

class PurchaseRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // PR 1
        $pr1 = PurchaseRequest::create([
            'pr_number' => 'PR/2026/03/001',
            'branch_id' => 1,
            'request_date' => '2026-03-20',
            'status' => 'approved',
            'notes' => 'Request for IT equipment',
        ]);

        PurchaseRequestDetail::create([
            'purchase_request_id' => $pr1->id,
            'item_id' => 1,
            'quantity' => 5,
            'estimated_price' => 12000000,
            'notes' => 'For new employees',
        ]);

        PurchaseRequestDetail::create([
            'purchase_request_id' => $pr1->id,
            'item_id' => 2,
            'quantity' => 5,
            'estimated_price' => 250000,
        ]);

        PurchaseRequestDetail::create([
            'purchase_request_id' => $pr1->id,
            'item_id' => 3,
            'quantity' => 5,
            'estimated_price' => 850000,
        ]);

        // PR 2
        $pr2 = PurchaseRequest::create([
            'pr_number' => 'PR/2026/03/002',
            'branch_id' => 2,
            'request_date' => '2026-03-22',
            'status' => 'approved',
            'notes' => 'Office supplies',
        ]);

        PurchaseRequestDetail::create([
            'purchase_request_id' => $pr2->id,
            'item_id' => 6,
            'quantity' => 50,
            'estimated_price' => 45000,
        ]);

        PurchaseRequestDetail::create([
            'purchase_request_id' => $pr2->id,
            'item_id' => 5,
            'quantity' => 2,
            'estimated_price' => 3500000,
        ]);
    }
}
