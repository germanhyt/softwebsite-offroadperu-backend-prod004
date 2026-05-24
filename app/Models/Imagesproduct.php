<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagesproduct extends Model
{
    use HasFactory;

    protected $table = 'imagesproducts';

    protected $fillable = [
        'id_product',
        'id_image',
        'state',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'id_image');
    }
}
