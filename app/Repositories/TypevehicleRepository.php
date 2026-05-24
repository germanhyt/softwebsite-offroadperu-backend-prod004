<?php

namespace App\Repositories;

use App\Interfaces\TypevehicleRepositoryInterface;
use App\Models\Typevehicle;

class TypevehicleRepository implements TypevehicleRepositoryInterface
{

    public function getAll()
    {
        return Typevehicle::all();
    }
}
