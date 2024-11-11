<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteList extends Model
{
    //property
    public int $id;
    public string $id_favorite;
    public string $id_product;

    use HasFactory;

    protected $fillable = [
        'id_favorite',
        'id_product',
    ];
}
