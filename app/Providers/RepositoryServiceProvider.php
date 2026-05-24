<?php

namespace App\Providers;

use App\Interfaces\BrandRepositoryInterface;
use App\Interfaces\BrandsmodellRepositoryInterface;
use App\Interfaces\BrandvehicleRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\ComplementaryproductRepositoryInterface;
use App\Interfaces\ModellRepositoryInterface;
use App\Interfaces\ProductsRepositoryInterface;
use App\Interfaces\SubcategoryRepositoryInterface;
use App\Interfaces\TypevehicleRepositoryInterface;
use App\Repositories\BrandRepository;
use App\Repositories\BrandsmodellRepository;
use App\Repositories\BrandvehicleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ComplementaryproductRepository;
use App\Repositories\ModellRepository;
use App\Repositories\ProductsRepository;
use App\Repositories\SubcategoryRepository;
use App\Repositories\TypevehicleRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductsRepositoryInterface::class,
            ProductsRepository::class
        );

        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            BrandRepositoryInterface::class,
            BrandRepository::class
        );

        $this->app->bind(
            TypevehicleRepositoryInterface::class,
            TypevehicleRepository::class
        );

        $this->app->bind(
            ModellRepositoryInterface::class,
            ModellRepository::class
        );

        $this->app->bind(
            ComplementaryproductRepositoryInterface::class,
            ComplementaryproductRepository::class
        );

        $this->app->bind(
            BrandvehicleRepositoryInterface::class,
            BrandvehicleRepository::class
        );

        $this->app->bind(
            BrandsmodellRepositoryInterface::class,
            BrandsmodellRepository::class
        );

        $this->app->bind(
            SubcategoryRepositoryInterface::class,
            SubcategoryRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
