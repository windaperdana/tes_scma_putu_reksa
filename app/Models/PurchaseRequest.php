<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    protected $fillable = [
        'pr_number',
        'branch_id',
        'request_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'request_date' => 'date',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function details()
    {
        return $this->hasMany(PurchaseRequestDetail::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
