<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckoutList extends Model
{
    //property
    public int $id;
    public string $id_checkout;
    public string $id_product;

    use HasFactory;

    protected $fillable = [
        'id',
        'id_product',
        'id_checkout'
    ];
}
