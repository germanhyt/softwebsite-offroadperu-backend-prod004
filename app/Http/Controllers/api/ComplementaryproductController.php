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

        $productsDTO = $complementaryproducts->map(function ($complementprod) {
            if (!$complementprod || !$complementprod->complementaryproduct) {
                return null;
            }

            return [
                'id' => $complementprod->id,
                'product' => [
                    'id' => $complementprod->product->id ?? null,
                    'name' => $complementprod->product->name ?? null,
                ],
                'complementaryproduct' => [
                    'id' => $complementprod->complementaryproduct->id,
                    'name' => $complementprod->complementaryproduct->name,
                    'description' => $complementprod->complementaryproduct->description,
                    'img' => $complementprod->complementaryproduct->img,
                    'price' => $complementprod->complementaryproduct->price,
                    'stock' => $complementprod->complementaryproduct->stock,
                    'state' => $complementprod->complementaryproduct->state,
                ],
            ];
        })->filter()->values();

        return response()->json($productsDTO);
    }

    public function getComplementariesByproduct($id)
    {
        if (!is_numeric($id) || (int) $id <= 0) {
            return response()->json(['message' => 'Id inválido'], 422);
        }

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

            $categoryRelation = optional($complementprod->complementaryproduct->categoriesproduct->first())->category;

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
                    'id' => $categoryRelation->id ?? null,
                    'name' => $categoryRelation->name ?? null,
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
