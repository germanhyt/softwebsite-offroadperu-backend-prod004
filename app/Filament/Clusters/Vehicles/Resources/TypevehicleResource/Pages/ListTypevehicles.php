<?php

namespace App\Filament\Clusters\Vehicles\Resources\TypevehicleResource\Pages;

use App\Filament\Clusters\Vehicles\Resources\TypevehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypevehicles extends ListRecords
{
    protected static string $resource = TypevehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
