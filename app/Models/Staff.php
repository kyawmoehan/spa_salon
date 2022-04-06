<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Staff extends Model
{

    protected $fillable = [
        'name',
        'nrc',
        'image',
        'address',
        'phone',
        'email',
        'position',
        'remark',
    ];

    use HasFactory;
}
