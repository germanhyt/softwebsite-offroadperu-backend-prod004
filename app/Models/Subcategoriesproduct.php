<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategoriesproduct extends Model
{
    use HasFactory;

    protected $table = 'subcategoriesproducts';

    protected $fillable = [
        'id_subcategory',
        'id_product',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'id_subcategory');
    }
}
