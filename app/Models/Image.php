<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'name',
        'state',
    ];

    public function imagesproduct()
    {
        return $this->hasMany(Imagesproduct::class, 'id_image');
    }
}
