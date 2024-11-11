<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{

    //property
    public int $id;
    public string $id_user;
//    public string $id_product;
    public string $title;
    public string $description;

    use HasFactory;

    protected $fillable = [
        'id_user',
//        'id_product',
        'title',
        'description',
    ];
}
