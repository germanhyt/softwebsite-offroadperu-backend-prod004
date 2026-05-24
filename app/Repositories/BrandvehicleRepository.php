<?php

namespace App\Repositories;

use App\Interfaces\BrandvehicleRepositoryInterface;
use App\Models\Brandvehicle;

class BrandvehicleRepository implements BrandvehicleRepositoryInterface
{

    public function getAll()
    {
        return Brandvehicle::all();
    }

    public function getByTypevehicle($id)
    {
        return Brandvehicle::where('id_typevehicle', $id)->get();
    }
}
