<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'po_number',
        'purchase_request_id',
        'supplier_id',
        'order_date',
        'expected_date',
        'total_amount',
        'status',
        'notes'
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function details()
    {
        return $this->hasMany(PurchaseOrderDetail::class);
    }

    public function purchaseReceipts()
    {
        return $this->hasMany(PurchaseReceipt::class);
    }
}
