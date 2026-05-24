<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Brandvehicle extends Model
{
    use HasFactory;

    protected $table = 'brandvehicles';

    protected $fillable = [
        'name',
        'description',

        'id_typevehicle',

        'state'
    ];



    public function products()
    {
        return $this->hasMany(Product::class, 'id_brandvehicle');
    }

    
    public function typevehicle(): BelongsTo
    {
        return $this->belongsTo(Typevehicle::class, 'id_typevehicle');
    }
}
