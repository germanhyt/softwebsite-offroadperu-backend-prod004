<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'img',
        'id_typevehicle',
        'id_branvehicle',
        'id_brand',
        'id_category',

        'price',
        'stock',
        'discount',
        'trend',

        'most_requested',
        'front_lift',
        'rear_lift',

        'description_general',

        'state',
    ];



    public function categoriesproduct()
    {
        return $this->hasMany(Categoriesproduct::class, 'id_product');
    }

    public function subcategoriesproduct()
    {
        return $this->hasMany(Subcategoriesproduct::class, 'id_product');
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand');
    }

    public function brandvehicle()
    {
        return $this->belongsTo(Brandvehicle::class, 'id_brandvehicle');
    }

    public function typevehicle()
    {
        return $this->belongsTo(Typevehicle::class, 'id_typevehicle');
    }

    public function modell()
    {
        return $this->belongsTo(Modell::class, 'id_modell');
    }

    public function featuresproduct()
    {
        return $this->hasMany(Featuresproduct::class, 'id_product');
    }

    public function imagesproduct()
    {
        return $this->hasMany(Imagesproduct::class, 'id_product');
    }

    // public function complementaryproducts()
    // {
    //     return $this->hasMany(Complementaryproduct::class, 'id_product');
    // }

    public function complementaryproducts2()
    {
        return $this->hasMany(Complementaryproduct::class, 'id_complementaryproduct');
    }

    // public function modellsproduct()
    // {
    //     return $this->hasMany(Modellsproduct::class, 'id_product');
    // }

    // public function generaldescription()
    // {
    //     return $this->belongsTo(Generaldescription::class, 'id_generaldescription');
    // }


    // * Association with other models
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'categoriesproducts', 'id_product', 'id_category')->withTimestamps();
    }

    public function subcategories(): BelongsToMany
    {
        return $this->belongsToMany(Subcategory::class, 'subcategoriesproducts', 'id_product', 'id_subcategory')->withTimestamps();
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'imagesproducts', 'id_product', 'id_image')->withTimestamps();
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'featuresproducts', 'id_product', 'id_feature')->withTimestamps();
    }

    public function complementaryProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'complementaryproducts', 'id_product', 'id_complementaryproduct');
    }

    public function parentProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'complementaryproducts', 'id_complementaryproduct', 'id_product');
    }

    public function modells(): BelongsToMany
    {
        return $this->belongsToMany(Modell::class, 'modellsproducts', 'id_product', 'id_modell')
                    ->using(ModellsProduct::class)
                    ->withPivot('year_start', 'year_end')
                    ->withTimestamps();
    }

    public function modellsProducts(): HasMany
    {
        return $this->hasMany(Modellsproduct::class, 'id_product');
    }

}
