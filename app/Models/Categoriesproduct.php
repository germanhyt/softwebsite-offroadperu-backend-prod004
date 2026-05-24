<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoriesproduct extends Model
{
    use HasFactory;

    protected $table = 'categoriesproducts';

    protected $fillable = [
        'id_category',
        'id_product',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
}
