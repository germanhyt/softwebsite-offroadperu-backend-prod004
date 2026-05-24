<?php

namespace App\Repositories;

use App\Interfaces\ComplementaryproductRepositoryInterface;
use App\Models\Complementaryproduct;

class ComplementaryproductRepository implements ComplementaryproductRepositoryInterface
{

    public function getAll()
    {
        return Complementaryproduct::query()
            ->with([
                'product',
                'complementaryproduct',
            ])
            ->get();
    }

    public function getComplementariesByproduct($id)
    {

        $query = Complementaryproduct::where('id_product', $id);

        $query->with([
            'complementaryproduct.typevehicle',
            'complementaryproduct.brandvehicle',
            'complementaryproduct.modellsproduct.modell',
            'complementaryproduct.brand',
            'complementaryproduct.categoriesproduct.category',
        ]);

        $query  = $query->whereHas('complementaryproduct', function ($query) {
            $query->where('state', 1);
        });

        return $query->get();
    }
}
