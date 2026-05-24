<?php

namespace App\Filament\Clusters\Vehicles\Resources\BrandvehicleResource\Pages;

use App\Filament\Clusters\Vehicles\Resources\BrandvehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBrandvehicle extends CreateRecord
{
    protected static string $resource = BrandvehicleResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
