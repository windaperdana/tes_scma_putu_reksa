<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReceiptDetail extends Model
{
    protected $fillable = [
        'purchase_receipt_id',
        'item_id',
        'quantity_received',
        'price',
        'notes'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function purchaseReceipt()
    {
        return $this->belongsTo(PurchaseReceipt::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
