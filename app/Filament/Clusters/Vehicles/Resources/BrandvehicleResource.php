<?php

namespace App\Filament\Clusters\Vehicles\Resources;

use App\Filament\Clusters\Vehicles;
use App\Filament\Clusters\Vehicles\Resources\BrandvehicleResource\Pages;
use App\Models\Brandvehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;

class BrandvehicleResource extends Resource
{
    protected static ?string $model = Brandvehicle::class;
    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $label = 'Marca';
    protected static ?string $navigationLabel = 'Marcas de Vehículos';
    protected static ?string $cluster = Vehicles::class;
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Información General')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true),
                                Forms\Components\Select::make('id_typevehicle')
                                    ->label('Tipo de vehículo')
                                    ->relationship('typevehicle', 'name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Textarea::make('description')
                                    ->label('Descripción')
                                    ->columnSpan('full')
                                    ->maxLength(255),
                            ])->columns(2),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Estado')
                            ->schema([
                                Forms\Components\Toggle::make('state')
                                    ->label('Activo')
                                    ->required()
                                    ->default(true),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('typevehicle.name')
                    ->label('Tipo de vehículo')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('state')
                    ->label('Estado')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->deferFilters()
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrandvehicles::route('/'),
            'create' => Pages\CreateBrandvehicle::route('/create'),
            'edit' => Pages\EditBrandvehicle::route('/{record}/edit'),
        ];
    }
}
