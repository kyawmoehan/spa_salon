<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'code',
        'price',
        'unit',
        'available',
        'remark',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class)->withTrashed();
    }
}
