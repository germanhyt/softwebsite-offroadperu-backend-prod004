<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complementaryproduct extends Model
{
    use HasFactory;

    protected $table = 'complementaryproducts';

    protected $fillable = [
        'id_product',
        'id_complementaryproduct',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function complementaryproduct()
    {
        return $this->belongsTo(Product::class, 'id_complementaryproduct');
    }
}
