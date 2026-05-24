<?php

namespace App\Filament\Clusters\Vehicles\Resources\TypevehicleResource\Pages;

use App\Filament\Clusters\Vehicles\Resources\TypevehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypevehicle extends EditRecord
{
    protected static string $resource = TypevehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
