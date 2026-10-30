<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'shipping_method',
        'payment_method',
        'shipping_price',
        'town',
        'street',
        'house_number',
        'region',
        'postal_code',
        'country',
        'total_price',
    ];
    

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
