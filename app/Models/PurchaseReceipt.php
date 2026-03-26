<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReceipt extends Model
{
    protected $fillable = [
        'pb_number',
        'purchase_order_id',
        'receipt_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'receipt_date' => 'date',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function details()
    {
        return $this->hasMany(PurchaseReceiptDetail::class);
    }
}
