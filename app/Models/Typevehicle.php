<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typevehicle extends Model
{
    use HasFactory;

    protected $table = 'typevehicles';

    protected $fillable = [
        'name',
        'description',

        'state',
    ];

    protected $casts = [
        'state' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'id_typevehicle');
    }
}
