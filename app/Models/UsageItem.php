<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'date',
        'quantity',
        'source',
        'remark',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class)->withTrashed();
    }
}
