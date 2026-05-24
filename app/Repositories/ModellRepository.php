<?php

namespace App\Repositories;

use App\Interfaces\ModellRepositoryInterface;
use App\Models\Modell;

class ModellRepository implements ModellRepositoryInterface
{

    public function getAll()
    {
        return Modell::all();
    }

    public function getByBrandvehicle($id)
    {
        return Modell::where('id_brandvehicle', $id)->get();
    }
}
