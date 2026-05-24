<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modellsproduct extends Model
{
    use HasFactory;

    protected $table = 'modellsproducts';

    protected $fillable = [
        'id_product',
        'id_modell',

        'year_start',
        'year_end',

        'state',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function modell()
    {
        return $this->belongsTo(Modell::class, 'id_modell');
    }

    public function modellsproduct()
    {
        return $this->hasMany(Modellsproduct::class, 'id_modell');
    }
}
