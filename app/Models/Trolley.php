<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trolley extends Model
{
    use HasFactory;

    protected $fillable = [
        'qty',
        'id_checkout',
        'id_product',
        'id_user',
    ];
}
