<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $fillable = [
        'staff_id',
        'amount',
        'service_amount',
        'total_amount',
        'date',
        'remark',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
