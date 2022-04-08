<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'cost_type',
        'reason',
        'cost',
        'date',
        'remark'
    ];
}
