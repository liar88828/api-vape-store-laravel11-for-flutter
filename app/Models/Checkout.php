<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{

    //property
    public int $id;
    public int $id_user;
    public int $total;
    public string $payment_method;
    public int $payment_price;
    public string $delivery_method;
    public int $delivery_price;
    public array $id_trolley;

    use HasFactory;

    protected $fillable = [
        'id_user',
        'total',
        'payment_method',
        'payment_price',
        'delivery_method',
        'delivery_price',
    ];

    public function trolleys()
    {
        return $this->hasMany(Trolley::class);
    }

}
