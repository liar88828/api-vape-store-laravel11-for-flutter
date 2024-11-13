<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    //property
    public int $id;
    public string $name;
    public string $email;
    public string $password;

    use HasFactory, Notifiable, HasApiTokens;


    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'remember_token',
        "password"
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
