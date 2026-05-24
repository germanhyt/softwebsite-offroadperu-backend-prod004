<?php

namespace App\Repositories;

use App\Interfaces\ProductsRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductsRepository implements ProductsRepositoryInterface
{
    public function getAll()
    {
        return Product::all();
    }

    public function getById($id)
    {
        return Product::findOrFail($id);
    }

    public function getByTrend($id)
    {
        return Product::where('trend', $id)->get();
    }

    public function getByMostRequested($id)
    {
        return Product::where('most_requested', $id)->get();
    }

    public function getByName(array $filters)
    {
        $query = Product::query();

        if (isset($filters['name'])) {
            $query->where('name', 'LIKE', '%' . $filters['name'] . '%');
        }

        return $query->get();
    }

    public function getByDescription(array $filters)
    {
        $query = Product::query();

        if (isset($filters['description'])) {
            $query->where('description', 'LIKE', '%' . $filters['description'] . '%');
        }

        return $query->get();
    }


    public function filters(array $filters, $perPage)
    {
        $query = Product::query();


        if (isset($filters['typevehicle'])) {
            $query->whereHas('typevehicle', function ($query) use ($filters) {
                $query->where('name', 'LIKE', '%' . $filters['typevehicle'] . '%');
            });
        }

        if (isset($filters['brandvehicle'])) {
            $query->whereHas('brandvehicle', function ($query) use ($filters) {
                $query->where('name', 'LIKE', '%' . $filters['brandvehicle'] . '%');
            });
        }

        if (isset($filters['modell'])) {
            $query->whereExists(function ($query) use ($filters) {
                $query->select(DB::raw(1))
                    ->from('modellsproducts as mp')
                    ->join('modells as m', 'm.id', '=', 'mp.id_modell')
                    ->whereColumn('mp.id_product', 'products.id')
                    ->where('m.name', 'LIKE', '%' . $filters['modell'] . '%');
            });
        }

        if (isset($filters['brand'])) {
            $query->whereHas('brand', function ($query) use ($filters) {
                $query->where('name', 'LIKE', '%' . $filters['brand'] . '%');
            });
        }


        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['description'])) {
            $query->where('description', 'like', '%' . $filters['description'] . '%');
        }


        if (isset($filters['id_stock'])) {
            if ($filters['id_stock'] == 1) {
                $query->where('stock', '>', 0);
            } else if ($filters['id_stock'] == 2) {
                $query->where('stock', 0);
            }
        }

        if (isset($filters['price_min']) || isset($filters['price_max'])) {

            if (isset($filters['price_min']) && isset($filters['price_max'])) {
                $query->whereBetween('price', [$filters['price_min'], $filters['price_max']]);
            } else if (isset($filters['price_min'])) {
                $query->where('price', '>=', $filters['price_min']);
            } else if (isset($filters['price_max'])) {
                $query->where('price', '<=', $filters['price_max']);
            }
        }

        if (isset($filters['category'])) {
            $query->whereHas('categoriesproduct', function ($query) use ($filters) {
                $query->whereHas('category', function ($query) use ($filters) {
                    $query->where('name', 'LIKE', '%' . $filters['category'] . '%');
                });
            });
        }

        if (isset($filters['id_category'])) {

            $query->whereHas('categoriesproduct', function ($query) use ($filters) {
                $query->where('id_category', $filters['id_category']);
            });
        }

        if (isset($filters['id_subcategory'])) {
            $query->whereHas('subcategoriesproduct', function ($query) use ($filters) {
                $query->where('id_subcategory', $filters['id_subcategory']);
            });
        }



        if (isset($filters['mostrequested'])) {
            $query->where('most_requested', $filters['mostrequested']);
        }

        if (isset($filters['state'])) {
            $query->where('state', $filters['state']);
        }

        return $query->paginate($perPage);
    }

    public function getPaginated($perPage)
    {
        return Product::paginate($perPage);
    }
}
