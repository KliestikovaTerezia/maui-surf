<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    // Určujeme, ktoré atribúty môžu byť hromadne priradené (mass assignable)
    protected $fillable = ['user_id', 'product_id', 'quantity', 'size'];

    // Ak chcete pridať vzťah k používateľovi, môžete to definovať ako:
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Pridanie vzťahu s produktom
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

