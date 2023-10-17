<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetails extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventorie::class, 'inventory_id', 'id');
    }
}
