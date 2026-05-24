<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'url',
        
        'state',
    ];

    public function imagesproduct()
    {
        return $this->hasMany(Imagesproduct::class, 'id_image');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'imagesproducts', 'id_image', 'id_product');
    }
}
