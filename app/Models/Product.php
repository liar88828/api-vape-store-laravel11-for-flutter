<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

// property
    public int $id;
    public int $id_user;
    public string $name;
    public int $qty;
    public int $price;
    public string $category;
    public string $description;

    use HasFactory;

    protected $fillable = [
        'id_user',
        'name',
        'qty',
        'price',
        "category",
        'description',
    ];
}
