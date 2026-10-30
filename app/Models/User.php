<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'name', 'email', 'phone_number', 'country', 'password'
    ];

    protected $hidden = [ //chranene udaje
        'password', 'remember_token',
    ];


    public function favorites(){
        return $this->belongsToMany(Product::class, 'favorites')->withTimestamps();
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
    protected $casts = [
        'is_admin' => 'boolean',
    ];

}