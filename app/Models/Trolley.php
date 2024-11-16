<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trolley extends Model
{
    //property
    public int $id;
    public int $id_checkout;
    public int $id_product;
    public int $id_user;
    public int $qty;

    use HasFactory;

    protected $fillable = [
        'id_checkout',
        'id_product',
        'id_user',
        'qty',
        'type',
    ];
}
