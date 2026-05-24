<?php

namespace App\Filament\Clusters\Products\Resources\ProductResource\Widgets;

use App\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class ProductStats extends BaseWidget
{   
    use InteractsWithPageTable;
    protected static ?string $pollingInterval = null;

    protected function getTablePage():string {
        return ListProducts::class;
    }    
    
    protected function getStats(): array
    {

        $formatNumber = function (int $number): string {
            if ($number < 1000) {
                return (string) Number::format($number, 0);
            }

            if ($number < 1000000) {
                return Number::format($number / 1000, 2) . 'k';
            }

            return Number::format($number / 1000000, 2) . 'm';
        };

        return [
            Stat::make('Productos Totales', $this->getPageTableQuery()->count()),
            // Stat::make('Total Stock',$this->getPageTableQuery()->sum('stock')),
            // Stat::make('Valor Total', '$' . $formatNumber($this->getPageTableQuery()->sum('price'), 2)),
        ];
    }
}
