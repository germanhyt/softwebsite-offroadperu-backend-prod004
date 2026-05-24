<?php

namespace App\Http\Controllers\api;

use App\Interfaces\BrandsmodellRepositoryInterface;
use App\Http\Controllers\Controller;

class BrandsmodellController extends Controller
{
    //

    private BrandsmodellRepositoryInterface $brandsmodellRepositoryI;

    public function __construct(BrandsmodellRepositoryInterface $brandsmodellRepositoryI)
    {
        $this->brandsmodellRepositoryI = $brandsmodellRepositoryI;
    }

    public function index()
    {
        $brandsmodell = $this->brandsmodellRepositoryI->getAll();

        $brandsmodellDTO = $brandsmodell->map(function ($brandsmodell) {
            return [
                'id' => $brandsmodell->id,
                'brand' => [
                    'id' => $brandsmodell->brand->id,
                    'name' => $brandsmodell->brand->name,
                    'description' => $brandsmodell->brand->description,
                ]
            ];
        });

        return response()->json($brandsmodellDTO);
    }

    public function getByModell($id)
    {
        $brandsmodell = $this->brandsmodellRepositoryI->getByModell($id);

        $brandsmodellDTO = $brandsmodell->map(function ($brandsmodell) {
            return [
                'id' => $brandsmodell->brand->id,
                'name' => $brandsmodell->brand->name,
                'description' => $brandsmodell->brand->description,
            ];
        });

        return response()->json($brandsmodellDTO);
    }
}
