<?php

namespace App\Repositories;

use App\Interfaces\ComplementaryproductRepositoryInterface;
use App\Models\Complementaryproduct;

class ComplementaryproductRepository implements ComplementaryproductRepositoryInterface
{

    public function getAll()
    {
        return Complementaryproduct::all();
    }

    public function getComplementariesByproduct($id)
    {
        return Complementaryproduct::where('id_product', $id)->get();
    }
}
