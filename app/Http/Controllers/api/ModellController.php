<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\ModellRepositoryInterface;

class ModellController extends Controller
{
    //
    private ModellRepositoryInterface $modellRepositoryI;

    public function __construct(ModellRepositoryInterface $modellRepositoryI)
    {
        $this->modellRepositoryI = $modellRepositoryI;
    }

    public function index()
    {
        $modells = $this->modellRepositoryI->getAll();

        $modellsDTO = $modells->map(function ($modell) {
            return [
                'id' => $modell->id,
                'name' => $modell->name,
                'description' => $modell->description,
            ];
        });

        return response()->json($modellsDTO);
    }

    public function getByBrandvehicle($id)
    {
        $modells = $this->modellRepositoryI->getByBrandvehicle($id);

        $modellsDTO = $modells->map(function ($modell) {
            return [
                'id' => $modell->id,
                'name' => $modell->name,
                'description' => $modell->description,
            ];
        });

        return response()->json($modellsDTO);
    }
}
