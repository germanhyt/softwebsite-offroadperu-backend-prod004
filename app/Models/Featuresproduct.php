<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Featuresproduct extends Model
{
    use HasFactory;

    protected $table = 'featuresproducts';

    protected $fillable = [
        'id_product',
        'id_feature',
        'state',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class, 'id_feature');
    }
}
