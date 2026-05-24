<?php

namespace App\Filament\Resources\BrandResource\Widgets;

use App\Models\Brand;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\HtmlString;

class BrandStatsWidget extends BaseWidget
{

    protected function getHeading(): ?string
    {
        return 'Cantidad de productos por marca';
    }

    protected function getStats(): array
    {
        $brands = Brand::withCount('products')->get();
        $stats = [];

        foreach ($brands as $brand) {
            $url = '/dashboard/products/products?tableSearch=' . urlencode($brand->name);
            $imageUrl = asset('/storage/' . $brand->imgbg);

            $lightModeStyles = "
            background: linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.5)), url('$imageUrl');
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            padding: 20px;
            font-weight: bold;
            color: white;
            display: flex;
            height: 120px;
        ";

            $darkModeStyles = "
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6)), url('$imageUrl');
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            padding: 20px;
            font-weight: bold;
            color: white;
            display: flex;
            height: 120px;
        ";

            $stats[] = Stat::make(
                '',
                new HtmlString("<span style=' color: white;'>  $brand->products_count</span>")
            )
                ->description($brand->name)
                ->color('primary')
                ->url($url)
                ->extraAttributes([
                    'x-data' => "{
                    darkMode: window.matchMedia('(prefers-color-scheme: dark)').matches
                }",
                    'x-bind:style' => "darkMode ? `$lightModeStyles` : `$darkModeStyles`",
                ]);
        }

        return $stats;
    }
}
