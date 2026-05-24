<?php

namespace App\Filament\Clusters\Vehicles\Resources\BrandvehicleResource\Pages;

use App\Filament\Clusters\Vehicles\Resources\BrandvehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrandvehicles extends ListRecords
{
    protected static string $resource = BrandvehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
