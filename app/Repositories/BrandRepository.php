<?php

namespace App\Repositories;

use App\Interfaces\BrandRepositoryInterface;
use App\Models\Brand;

class BrandRepository implements BrandRepositoryInterface
{

    public function getAll()
    {
        return Brand::all();
    }

    public function getByModell($id)
    {
        return Brand::where('id_modell', $id)->get();
    }
}
