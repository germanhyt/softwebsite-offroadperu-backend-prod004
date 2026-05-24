<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\ComplementaryproductRepositoryInterface;

class ComplementaryproductController extends Controller
{
    //
    private ComplementaryproductRepositoryInterface $complementaryproductRepositoryI;

    public function __construct(ComplementaryproductRepositoryInterface $complementaryproductRepositoryI)
    {
        $this->complementaryproductRepositoryI = $complementaryproductRepositoryI;
    }

    public function index()
    {
        $complementaryproducts = $this->complementaryproductRepositoryI->getAll();

        return response()->json($complementaryproducts);
    }

    public function getComplementariesByproduct($id)
    {
        $complementaryproducts = $this->complementaryproductRepositoryI->getComplementariesByproduct($id);


        $productsDTO = $complementaryproducts->map(function ($complementprod) {

            // $complementaryproduct = $complement->complementaryproduct;


            if (!$complementprod) {
                return null;
            }


            $models = collect($complementprod->complementaryproduct->modellsproduct)->map(
                function ($modprod) {
                    return [
                        'id' => $modprod->modell->id,
                        'name' => $modprod->modell->name,
                        'year_start' => $modprod->year_start,
                        'year_end' => $modprod->year_end,
                    ];
                }
            );

            return [
                'id' => $complementprod->complementaryproduct->id,
                'name' => $complementprod->complementaryproduct->name,
                'description' => $complementprod->complementaryproduct->description,
                'typevehicle' => [
                    'id' => $complementprod->complementaryproduct->typevehicle->id ?? null,
                    'name' => $complementprod->complementaryproduct->typevehicle->name ?? null,
                ],
                'brandvehicle' => [
                    'id' => $complementprod->complementaryproduct->brandvehicle->id ?? null,
                    'name' => $complementprod->complementaryproduct->brandvehicle->name ?? null,
                ],
                'models' => $models ?? null,
                'brand' => [
                    'id' => $complementprod->complementaryproduct->brand->id ?? null,
                    'name' => $complementprod->complementaryproduct->brand->name ?? null,
                ],
                'category' => [
                    'id' => $complementprod->complementaryproduct->category->id ?? null,
                    'name' => $complementprod->complementaryproduct->category->name ?? null,
                ],
                'img' => $complementprod->complementaryproduct->img,
                'stock' => $complementprod->complementaryproduct->stock,
                'price' => $complementprod->complementaryproduct->price,
                'discount' => $complementprod->complementaryproduct->discount,

                'year_start' => $complementprod->complementaryproduct->year_start,
                'year_end' => $complementprod->complementaryproduct->year_end,
                // 'lift' => $complementprod->complementaryproduct->lift,
                'front_lift' => $complementprod->complementaryproduct->front_lift,
                'rear_lift' => $complementprod->complementaryproduct->rear_lift,

                'state' => $complementprod->complementaryproduct->state,
            ];
        });

        return response()->json($productsDTO);
    }
}
