<?php

namespace App\Repositories;

use App\Interfaces\BrandsmodellRepositoryInterface;
use App\Models\Brandsmodell;

class BrandsmodellRepository implements BrandsmodellRepositoryInterface
{

    public function getAll()
    {
        return Brandsmodell::all();
    }

    public function getByModell($id)
    {
        return Brandsmodell::where('id_modell', $id)->get();
    }
}
