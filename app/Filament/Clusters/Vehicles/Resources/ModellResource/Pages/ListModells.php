<?php

namespace App\Filament\Clusters\Vehicles\Resources\ModellResource\Pages;

use App\Filament\Clusters\Vehicles\Resources\ModellResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListModells extends ListRecords
{
    protected static string $resource = ModellResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
