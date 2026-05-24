<?php

namespace App\Repositories;

use App\Interfaces\ProductsRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductsRepository implements ProductsRepositoryInterface
{
    private function productRelations(): array
    {
        return [
            'brand',
            'brandvehicle',
            'typevehicle',
            'modellsproduct.modell',
            'featuresproduct.feature',
            'imagesproduct.image',
            'categoriesproduct.category',
            'subcategoriesproduct.subcategory',
        ];
    }

    private function escapeLike(string $value): string
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $value);
    }

    private function sanitizePerPage($perPage): int
    {
        $resolvedPerPage = (int) ($perPage ?? 15);
        $resolvedPerPage = max(1, $resolvedPerPage);

        return min($resolvedPerPage, 100);
    }

    public function getAll()
    {
        $products = Product::query()
            ->with($this->productRelations())
            ->get();

        return $products;
    }

    public function getById($id)
    {
        return Product::query()
            ->with($this->productRelations())
            ->findOrFail($id);
    }

    public function getByTrend($id)
    {
        $query = Product::query()
            ->with($this->productRelations())
            ->where('trend', $id);

        $query->where('state', 1);

        return $query->get();
    }

    public function getByMostRequested($id)
    {

        $query = Product::query()
            ->with($this->productRelations())
            ->where('most_requested', $id);

        $query->where('state', 1);

        return $query->get();
    }

    public function getByName(array $filters)
    {
        $query = Product::query()
            ->with($this->productRelations());

        if (isset($filters['name'])) {
            $searchName = $this->escapeLike((string) $filters['name']);
            $query->where('name', 'LIKE', '%' . $searchName . '%');
        }

        $query->where('state', 1);

        return $query->get();
    }

    public function getByDescription(array $filters)
    {
        $query = Product::query()
            ->with($this->productRelations());

        if (isset($filters['description'])) {
            $searchDescription = $this->escapeLike((string) $filters['description']);
            $query->where('description', 'LIKE', '%' . $searchDescription . '%');
        }

        $query->where('state', 1);

        return $query->get();
    }


    public function filters(array $filters, $perPage)
    {
        $query = Product::query()
            ->with($this->productRelations());


        if (isset($filters['typevehicle'])) {
            $query->whereHas('typevehicle', function ($query) use ($filters) {
                $searchTypeVehicle = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], (string) $filters['typevehicle']);
                $query->where('name', 'LIKE', '%' . $searchTypeVehicle . '%');
            });
        }

        if (isset($filters['brandvehicle'])) {
            $query->whereHas('brandvehicle', function ($query) use ($filters) {
                $searchBrandVehicle = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], (string) $filters['brandvehicle']);
                $query->where('name', 'LIKE', '%' . $searchBrandVehicle . '%');
            });
        }

        if (isset($filters['modell'])) {
            $query->whereExists(function ($query) use ($filters) {
                $searchModel = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], (string) $filters['modell']);
                $query->select(DB::raw(1))
                    ->from('modellsproducts as mp')
                    ->join('modells as m', 'm.id', '=', 'mp.id_modell')
                    ->whereColumn('mp.id_product', 'products.id')
                    ->where('m.name', 'LIKE', '%' . $searchModel . '%');
            });
        }

        if (isset($filters['brand'])) {
            $query->whereHas('brand', function ($query) use ($filters) {
                $searchBrand = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], (string) $filters['brand']);
                $query->where('name', 'LIKE', '%' . $searchBrand . '%');
            });
        }


        if (isset($filters['name'])) {
            $searchName = $this->escapeLike((string) $filters['name']);
            $query->where('name', 'LIKE', '%' . $searchName . '%');
        }

        if (isset($filters['description'])) {
            $searchDescription = $this->escapeLike((string) $filters['description']);
            $query->where('description', 'LIKE', '%' . $searchDescription . '%');
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
                    $searchCategory = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], (string) $filters['category']);
                    $query->where('name', 'LIKE', '%' . $searchCategory . '%');
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

        return $query->paginate($this->sanitizePerPage($perPage));
    }

    public function getPaginated($perPage)
    {
        return Product::query()
            ->with($this->productRelations())
            ->paginate($this->sanitizePerPage($perPage));
    }
}
