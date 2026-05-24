<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\SubcategoryRepositoryInterface;

class SubcategoryController extends Controller
{
    //
    private SubcategoryRepositoryInterface $subcategoryRepositoryI;


    public function __construct(SubcategoryRepositoryInterface $subcategoryRepositoryI)
    {
        $this->subcategoryRepositoryI = $subcategoryRepositoryI;
    }

    public function showAll()
    {
        $subcategories = $this->subcategoryRepositoryI->getAll();

        $subcategoriesDTO = $subcategories->map(function ($subcategory) {
            return [
                'id' => $subcategory->id,
                'name' => $subcategory->name,
                'description' => $subcategory->description,
            ];
        });

        return response()->json($subcategoriesDTO);
    }

    public function showByIdcategory($id)
    {
        $subcategories = $this->subcategoryRepositoryI->getByIdcategory($id);

        $subcategoriesDTO = $subcategories->map(function ($subcategory) {
            return [
                'id' => $subcategory->id,
                'name' => $subcategory->name,
                'description' => $subcategory->description,
            ];
        });

        return response()->json($subcategoriesDTO);
    }
}
