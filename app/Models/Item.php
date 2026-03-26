<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'unit',
        'price',
        'stock',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function purchaseRequestDetails()
    {
        return $this->hasMany(PurchaseRequestDetail::class);
    }

    public function purchaseOrderDetails()
    {
        return $this->hasMany(PurchaseOrderDetail::class);
    }

    public function purchaseReceiptDetails()
    {
        return $this->hasMany(PurchaseReceiptDetail::class);
    }
}
