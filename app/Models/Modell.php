<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Modell extends Model
{
    use HasFactory;

    protected $table = 'modells';

    protected $fillable = [
        'name',
        'description',

        'id_brandvehicle',

        'state',
    ];

    protected $casts = [
        'state' => 'boolean',
    ];


    public function products()
    {
        return $this->hasMany(Product::class, 'id_modell');
    }

    public function brandvehicle(): BelongsTo
    {
        return $this->belongsTo(Brandvehicle::class, 'id_brandvehicle');
    }
}
