<?php

namespace App\Filament\Clusters\Products\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';
    protected static ?string $title = 'Imágenes adicionales';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('url')
                    ->label('Imagenes adicionales')
                    ->directory('/images/accessory',)
                    ->preserveFilenames()
                    ->image()
                    ->imageEditor()
                    ->columnSpan('full'),
                // ->disk('public'),
                // description
                Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->columnSpan('full'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('url')
            ->columns([
                Tables\Columns\ImageColumn::make('url')
                    ->label('Imagen')
                    ->height('100px'),
                //url
                // Tables\Columns\TextColumn::make('url')
                //     ->label('URL'),
                // description
                // Tables\Columns\TextColumn::make('description')
                //     ->label('Descripción'),
                // estate
                Tables\Columns\IconColumn::make('state')
                    ->label('Visibilidad')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Agregar Imagen'),
                // Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
                Tables\Actions\DetachAction::make()->label('Eliminar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
