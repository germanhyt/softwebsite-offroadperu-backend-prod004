<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Typevehicle extends Model
{
    use HasFactory;

    protected $table = 'typevehicles';

    protected $fillable = [
        'name',
        'description',

        'state',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'id_typevehicle');
    }

    public function brandvehicles(): HasMany
    {
        return $this->hasMany(Brandvehicle::class, 'id_typevehicle');
    }
}
