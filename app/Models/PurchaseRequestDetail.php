<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestDetail extends Model
{
    protected $fillable = [
        'purchase_request_id',
        'item_id',
        'quantity',
        'estimated_price',
        'notes'
    ];

    protected $casts = [
        'estimated_price' => 'decimal:2',
    ];

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
