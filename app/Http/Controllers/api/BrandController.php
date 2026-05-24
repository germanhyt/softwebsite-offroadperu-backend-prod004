<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\BrandRepositoryInterface;

class BrandController extends Controller
{
    //
    private BrandRepositoryInterface $brandRepositoryI;

    public function __construct(BrandRepositoryInterface $brandRepositoryI)
    {
        $this->brandRepositoryI = $brandRepositoryI;
    }

    public function index()
    {
        $brands = $this->brandRepositoryI->getAll();
        
        $brandsDTO = $brands->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name,
                'description' => $brand->description,
            ];
        });

        return response()->json($brandsDTO);
    }
}
