<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';

    protected $fillable = [
        'name',
        'description',

        'imgbg',
        'imglogo',


        'state',
    ];


    public function products()
    {
        return $this->hasMany(Product::class, 'id_brand');
    }


    public function brandsmodell()
    {
        return $this->hasMany(Brandsmodell::class, 'id_brand');
    }

    public function modell(): BelongsTo
    {
        return $this->belongsTo(Modell::class, 'id_modell');
    }
}
