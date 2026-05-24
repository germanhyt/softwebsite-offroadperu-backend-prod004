<?php

namespace App\Repositories;

use App\Interfaces\SubcategoryRepositoryInterface;
use App\Models\Subcategory;

class SubcategoryRepository implements SubcategoryRepositoryInterface
{

    public function getAll()
    {
        return Subcategory::all();
    }

    public function getByIdcategory($id)
    {
        return Subcategory::where('id_category', $id)->get();
    }
}
