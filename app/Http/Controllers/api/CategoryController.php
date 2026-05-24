<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    private CategoryRepositoryInterface $categoryRepositoryI;

    public function __construct(CategoryRepositoryInterface $categoryRepositoryI)
    {
        $this->categoryRepositoryI = $categoryRepositoryI;
    }


    public function index()
    {
        $categories = $this->categoryRepositoryI->getAll();

        $categoriesDTO = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
            ];
        });

        return response()->json($categoriesDTO);
    }
}
