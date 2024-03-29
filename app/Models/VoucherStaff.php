<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherStaff extends Model
{
    use HasFactory;
    protected $fillable = [
        'voucher_id',
        'staff_id',
        'service_id',
        'staff_pct',
        'staff_amount',
        'date',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
    
    public function staff()
    {
        return $this->belongsTo(Staff::class)->withTrashed();
    }

    public function service()
    {
        return $this->belongsTo(Service::class)->withTrashed();
    }
}
