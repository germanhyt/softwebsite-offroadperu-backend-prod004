<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generaldescription extends Model
{
    use HasFactory;

    protected $table = 'generaldescriptions';

    protected $fillable = [
        'description',
        'state',
    ];


    public function products()
    {
        return $this->hasMany(Product::class, 'id_generaldescription');
    }

    public function highlightsgeneraldescription()
    {
        return $this->hasMany(Highlightsgeneraldescription::class, 'id_generaldescription');
    }
}
