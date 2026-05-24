<?php

namespace App\Filament\Clusters\Vehicles\Resources\BrandvehicleResource\Pages;

use App\Filament\Clusters\Vehicles\Resources\BrandvehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBrandvehicle extends EditRecord
{
    protected static string $resource = BrandvehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
