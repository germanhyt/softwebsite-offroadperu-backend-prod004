<?php

namespace App\Filament\Clusters\Vehicles\Resources\ModellResource\Pages;

use App\Filament\Clusters\Vehicles\Resources\ModellResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateModell extends CreateRecord
{
    protected static string $resource = ModellResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
