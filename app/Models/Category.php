<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'state',
    ];



    public function categoriesproduct()
    {
        return $this->hasMany(Categoriesproduct::class, 'id_category');
    }


    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class, 'id_category');
    }
}
