<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\BrandvehicleRepositoryInterface;

class BrandvehicleController extends Controller
{
    //
    private BrandvehicleRepositoryInterface $brandvehicleRepository;

    public function __construct(BrandvehicleRepositoryInterface $brandvehicleRepository)
    {
        $this->brandvehicleRepository = $brandvehicleRepository;
    }

    public function index()
    {

        $brandvehicle = $this->brandvehicleRepository->getAll();

        $brandvehicleDTO = $brandvehicle->map(function ($brandvehicle) {
            return [
                'id' => $brandvehicle->id,
                'name' => $brandvehicle->name,
                'description' => $brandvehicle->description,

            ];
        });

        return response()->json($brandvehicleDTO);
    }

    public function showByTypeVehicle($id)
    {
        $brandvehicle = $this->brandvehicleRepository->getByTypeVehicle($id);

        $brandvehicleDTO = $brandvehicle->map(function ($brandvehicle) {
            return [
                'id' => $brandvehicle->id,
                'name' => $brandvehicle->name,
                'description' => $brandvehicle->description,

            ];
        });

        return response()->json($brandvehicleDTO);
    }
}
