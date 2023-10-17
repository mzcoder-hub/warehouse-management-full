<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function purchase()
    {
        return $this->belongsTo(Purchases::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventorie::class, 'inventory_id', 'id');
    }
}
