<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'price',
        'color',
        'size',
        'stock',
        'features',
        'category_id',
        'subcategory_id',
    ];    


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    // In Product model
    public function sizes()
    {
        return $this->hasMany(Size::class); // Adjust depending on your relationship
    }
    // In Product model
    protected $casts = [
        'sizes' => 'array',
    ];
    
    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }
    public function favoriteBy(){
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

}
