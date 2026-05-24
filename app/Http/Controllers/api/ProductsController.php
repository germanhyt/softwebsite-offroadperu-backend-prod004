<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductsRepositoryInterface;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //
    private ProductsRepositoryInterface $productsRepositoryI;

    public function __construct(ProductsRepositoryInterface $productsRepositoryI)
    {
        $this->productsRepositoryI = $productsRepositoryI;
    }

    public function index(Request $request)
    {
        $filters = [];
        $products = null;

        // Filtros avanzados
        if ($request->has('filter_typevehicle')) {
            $filters['typevehicle'] = $request->input('filter_typevehicle');
        }

        if ($request->has('filter_brandvehicle')) {
            $filters['brandvehicle'] = $request->input('filter_brandvehicle');
        }

        if ($request->has('filter_model')) {
            $filters['modell'] = $request->input('filter_model');
        }

        if ($request->has('filter_brand')) {
            $filters['brand'] = $request->input('filter_brand');
        }


        // Resto de filtros
        if ($request->has('filter_name')) {
            $filters['name'] = $request->input('filter_name');
        }

        if ($request->has('filter_description')) {
            $filters['description'] = $request->input('filter_description');
        }

        if ($request->has('filter_category')) {
            $filters['category'] = $request->input('filter_category');
        }

        if ($request->has('filter_id_category')) {
            $filters['id_category'] = $request->input('filter_id_category');
        }

        if ($request->has('filter_id_subcategory')) {
            $filters['id_subcategory'] = $request->input('filter_id_subcategory');
        }

        if ($request->has('filter_price_min')) {
            $filters['price_min'] = $request->input('filter_price_min');
        }

        if ($request->has('filter_price_max')) {
            $filters['price_max'] = $request->input('filter_price_max');
        }


        if ($request->has('filter_mostrequested')) {
            $filters['mostrequested'] = $request->input('filter_mostrequested');
        }

        if ($request->has('filter_id_stock')) {
            $filters['id_stock'] = $request->input('filter_id_stock');
        }


        if (count($filters) > 0) {
            $products = $this->productsRepositoryI->filters($filters, $request->input('perPage'));
        } else {
            $products = $this->productsRepositoryI->getPaginated($request->input('perPage'));
        }

        $productsCollect = collect($products->items());

        $productsDTO = $productsCollect->map(function ($product) {


            $models = collect($product->modellsproduct)->map(function ($modprod) {
                return [
                    'id' => $modprod->modell->id,
                    'name' => $modprod->modell->name,
                    'year_start' => $modprod->year_start,
                    'year_end' => $modprod->year_end,
                ];
            });

            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'typevehicle' => [
                    'id' => $product->typevehicle->id ?? null,
                    'name' => $product->typevehicle->name ?? null,
                ],
                'brandvehicle' => [
                    'id' => $product->brandvehicle->id ?? null,
                    'name' => $product->brandvehicle->name ?? null,
                ],
                'models' => $models ?? [],
                'brand' => [
                    'id' => $product->brand->id ?? null,
                    'name' => $product->brand->name ?? null,
                    'description' => $product->brand->description ?? null,
                ],
                'subcategory' => [
                    'id' => $product->subcategory->id ?? null,
                    'name' => $product->subcategory->name ?? null,
                ],
                'category' => [
                    'id' => $product->subcategory->category->id ?? null,
                    'name' => $product->subcategory->category->name ?? null,
                ],
                'img' => $product->img,
                'stock' => $product->stock,
                'price' => $product->price,
                'discount' => $product->discount,

                'range_years' => $product->range_years,
                // 'lift' => $product->lift,
                'front_lift' => $product->front_lift,
                'rear_lift' => $product->rear_lift,

                'state' => $product->state,
            ];
        });


        return response()->json([
            'data' => $productsDTO ?? [],
            'from' => $products->firstItem(),
            'to' => $products->lastItem(),
            'perPage' => $products->perPage(),
            'currentPage' => $products->currentPage(),
            'lastPage' => $products->lastPage(),
            'total' => $products->total(),
        ]);
    }

    public function showAll()
    {
        $products = $this->productsRepositoryI->getAll();

        $productsCollect = collect($products);

        $productsDTO = $productsCollect->map(function ($product) {

            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
            ];
        });

        return response()->json($productsDTO);
    }

    public function showByName(Request $request)
    {
        $filters = [];
        $products = null;

        if ($request->has('filter_name')) {
            $filters['name'] = $request->input('filter_name');
        }

        if (!empty($filters)) {
            $products = $this->productsRepositoryI->getByName($filters);
        } else {
            $products = $this->productsRepositoryI->getAll();
        }

        return response()->json($products);
    }

    public function showByDescription(Request $request)
    {
        $filters = [];
        $products = null;

        if ($request->has('filter_description')) {
            $filters['description'] = $request->input('filter_description');
        }

        if (!empty($filters)) {
            $products = $this->productsRepositoryI->getByDescription($filters);
        } else {
            $products = $this->productsRepositoryI->getAll();
        }

        $productsDTO = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'brand' => [
                    'id' => $product->brand->id ?? null,
                    'name' => $product->brand->name ?? null,
                ],
                'subcategory' => [
                    'id' => $product->subcategory->id ?? null,
                    'name' => $product->subcategory->name ?? null,
                ],
                'category' => [
                    'id' => $product->subcategory->category->id ?? null,
                    'name' => $product->subcategory->category->name ?? null,
                ],
                'img' => $product->img,
                'stock' => $product->stock,
                'price' => $product->price,
            ];
        });


        return response()->json($productsDTO);
    }


    public function showByTrend()
    {
        $active = 1;

        $products = $this->productsRepositoryI->getByTrend($active);

        $productsCollect = collect($products);

        $productsDTO = $productsCollect->map(function ($product) {

            $modells = collect($product->modellsproduct)->map(function ($modprod) {
                return [
                    'id' => $modprod->modell->id,
                    'name' => $modprod->modell->name,
                    'year_start' => $modprod->year_start,
                    'year_end' => $modprod->year_end,
                ];
            });

            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'typevehicle' => [
                    'id' => $product->typevehicle->id ?? null,
                    'name' => $product->typevehicle->name ?? null,
                ],
                'brandvehicle' => [
                    'id' => $product->brandvehicle->id ?? null,
                    'name' => $product->brandvehicle->name ?? null,
                ],
                'models' =>  $modells ?? [],
                'brand' => [
                    'id' => $product->brand->id ?? null,
                    'name' => $product->brand->name ?? null,
                ],
                'subcategory' => [
                    'id' => $product->subcategory->id ?? null,
                    'name' => $product->subcategory->name ?? null,
                ],
                'category' => [
                    'id' => $product->subcategory->category->id ?? null,
                    'name' => $product->subcategory->category->name ?? null,
                ],
                'img' => $product->img,
                'stock' => $product->stock,
                'price' => $product->price,
                'discount' => $product->discount,

                'range_years' => $product->range_years,
                // 'lift' => $product->lift,

                'front_lift' => $product->front_lift,
                'rear_lift' => $product->rear_lift,

                'state' => $product->state,
            ];
        });

        return response()->json($productsDTO);
    }



    public function show($id)
    {
        $product = $this->productsRepositoryI->getById($id);


        $features = collect($product->featuresproduct)->map(function ($featureprod) {
            $feature = $featureprod->feature;

            return [
                'id' => $feature->id ?? null,
                'description' => $feature->description ?? null,
                // 'highlights' => collect($feature->highlightsfeature)->map(function ($highfeat) {
                //     return [
                //         'id' => $highfeat->highlight->id ?? null,
                //         'description' => $highfeat->highlight->description ?? null,
                //     ];
                // }),
            ];
        });

        // $generaldescription = [
        //     'id' => $product->generaldescription->id ?? null,
        //     'description' => $product->generaldescription->description ?? null,
        //     'highlights' => collect($product->generaldescription->highlightsgeneraldescription ?? [])->map(function ($highdesc) {
        //         return [
        //             'id' => $highdesc->highlight->id ?? null,
        //             'description' => $highdesc->highlight->description ?? null,
        //         ];
        //     }),
        // ];


        $images = collect($product->imagesproduct)->map(function ($imageprod) {
            $image = $imageprod->image;

            return [
                'id' => $image->id ?? null,
                'url' => $image->url ?? null,
            ];
        });

        $models = collect($product->modellsproduct)->map(function ($modprod) {
            return [
                'id' => $modprod->modell->id,
                'name' => $modprod->modell->name,
                'year_start' => $modprod->year_start,
                'year_end' => $modprod->year_end,
            ];
        });

        $categories = collect($product->categoriesproduct)->map(function ($catprod) {
            return [
                'id' => $catprod->category->id,
                'name' => $catprod->category->name,
            ];
        });

        $subcategories = collect($product->subcategoriesproduct)->map(function ($subcatprod) {
            return [
                'id' => $subcatprod->subcategory->id,
                'name' => $subcatprod->subcategory->name,
            ];
        });


        $productDTO = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'img' => $product->img,
            'typevehicle' => [
                'id' => $product->typevehicle->id ?? null,
                'name' => $product->typevehicle->name ?? null,
            ],
            'brandvehicle' => [
                'id' => $product->brandvehicle->id ?? null,
                'name' => $product->brandvehicle->name ?? null,
            ],
            'models' => $models ?? [],
            'brand' => [
                'id' => $product->brand->id ?? null,
                'name' => $product->brand->name ?? null,
                'imgbg' => $product->brand->imgbg ?? null,
                'imglogo' => $product->brand->imglogo ?? null,
            ],
            'categories' => $categories ?? [],
            'subcategories' => $subcategories ?? [],
            'features' => $features ?? [],
            // 'generaldescription' => $generaldescription ?? [],
            'images' => $images ?? [],
            'stock' => $product->stock,
            'price' => $product->price,
            'discount' => $product->discount,

            // 'lift' => $product->lift,
            'front_lift' => $product->front_lift,
            'rear_lift' => $product->rear_lift,

            'description_general' => $product->description_general,

            'state' => $product->state,
        ];

        return response()->json($productDTO);
    }
}
