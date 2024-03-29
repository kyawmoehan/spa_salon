<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemVoucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'voucher_id',
        'item_id',
        'quantity',
        'item_price',
        'source',
        'date',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class)->withTrashed();
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
