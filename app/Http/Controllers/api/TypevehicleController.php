<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\TypevehicleRepositoryInterface;

class TypevehicleController extends Controller
{
    //
    private TypevehicleRepositoryInterface $typevehicleRepositoryI;


    public function __construct(TypevehicleRepositoryInterface $typevehicleRepositoryI)
    {
        $this->typevehicleRepositoryI = $typevehicleRepositoryI;
    }

    public function index()
    {
        $typevehicles = $this->typevehicleRepositoryI->getAll();

        $typevehiclesDTO = $typevehicles->map(function ($typevehicle) {
            return [
                'id' => $typevehicle->id,
                'name' => $typevehicle->name,
                'description' => $typevehicle->description,
            ];
        });

        return response()->json($typevehiclesDTO);
    }
}
