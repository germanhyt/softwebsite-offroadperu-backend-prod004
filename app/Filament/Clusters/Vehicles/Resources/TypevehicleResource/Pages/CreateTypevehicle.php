<?php

namespace App\Filament\Clusters\Vehicles\Resources\TypevehicleResource\Pages;

use App\Filament\Clusters\Vehicles\Resources\TypevehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTypevehicle extends CreateRecord
{
    protected static string $resource = TypevehicleResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
