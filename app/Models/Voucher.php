<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_number',
        'customer_id',
        'date',
        'total',
        'paid',
        'discount',
        'voucher_staff',
        'remark',
    ];

    public function voucherStaff()
    {
        return $this->hasMany(VoucherStaff::class);
    }

    public function voucherItems()
    {
        return $this->hasMany(ItemVoucher::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'voucher_staff')->withTrashed();
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withTrashed();
    }
}
