<?php

namespace App\Filament\Clusters\Vehicles\Resources\ModellResource\Pages;

use App\Filament\Clusters\Vehicles\Resources\ModellResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditModell extends EditRecord
{
    protected static string $resource = ModellResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
