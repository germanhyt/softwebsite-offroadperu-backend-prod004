<?php

namespace App\Filament\Clusters\Products\Resources;

use App\Filament\Clusters\Products;
use App\Filament\Clusters\Products\Resources\ProductResource\Pages;
use App\Filament\Clusters\Products\Resources\ProductResource\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Clusters\Products\Resources\ProductResource\Widgets\ProductStats;
use App\Models\Product;
use Filament\Actions\SelectAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationLabel = 'Productos';

    protected static ?string $label = 'Producto';

    protected static ?string $cluster = Products::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true),
                                Forms\Components\TextInput::make('description')
                                    ->label('Descripción para buscador')
                                    ->columnSpan('full')
                                    ->maxLength(255),
                                Forms\Components\RichEditor::make('description_general')
                                    ->label('Descripción general')
                                    ->columnSpan('full')
                                    ->toolbarButtons(
                                        ['bold']
                                    ),
                                Forms\Components\Select::make('id_feature')
                                    ->label('Características')
                                    ->relationship(name: 'features', titleAttribute: 'description')
                                    ->getOptionLabelFromRecordUsing(fn($record) => strip_tags("{$record->id} - {$record->description}"))
                                    ->searchable()
                                    ->multiple()
                                    ->preload(),
                                // Forms\Components\Select::make('complementaryProducts')
                                //     ->label('Productos complementarios')
                                //     ->relationship(name: 'complementaryProducts', titleAttribute: 'name')
                                //     ->searchable()
                                //     ->multiple()
                                // // ->preload(),
                                Forms\Components\Select::make('complementaryProducts')
                                    ->label('Productos complementarios')
                                    ->relationship(name: 'complementaryProducts', titleAttribute: 'name')
                                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->id} - {$record->name}")
                                    ->searchable()
                                    ->multiple()

                            ]),
                        // images
                        Forms\Components\Section::make('Imágenes')
                            ->schema([
                                Forms\Components\FileUpload::make('img')
                                    ->label('Imagen principal')
                                    ->directory('images/accessory')
                                    ->disk('public')
                                    ->preserveFilenames()
                                    ->image()
                                    ->imageEditor()
                                    ->required(),

                            ]),
                        // Forms\Components\Section::make('Imágenes')
                        //     ->schema([
                        //         Forms\Components\FileUpload::make('img')
                        //             ->label('Imagen principal')
                        //             ->directory('images/accessory')
                        //             ->preserveFilenames()
                        //             ->image()
                        //             ->imageEditor()
                        //             ->required()
                        //             ->disk('public')
                        //     ]),

                        // pricing
                        Forms\Components\Section::make('Precios e inventario')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->label('Precio')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                                Forms\Components\TextInput::make('discount')
                                    ->label('Descuento')
                                    ->numeric()
                                    ->default(0),
                                Forms\Components\TextInput::make('stock')
                                    ->numeric(),
                            ])
                            ->columns(3),
                        Forms\Components\Section::make('Lift')
                            ->schema([
                                Forms\Components\TextInput::make('front_lift')
                                    ->label('Front')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('rear_lift')
                                    ->label('Rear')
                                    ->maxLength(255),
                            ])
                            ->columns(2),

                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()

                    ->schema([

                        Forms\Components\Section::make('Opciones de producto')

                            ->schema([
                                Forms\Components\Toggle::make('state')
                                    ->label(fn($get) => 'Estado (' . ($get('state') ? 'Activo' : 'Inactivo') . ')')
                                    ->live()
                                    ->required()
                                    ->default(true),
                                Forms\Components\Toggle::make('most_requested')
                                    ->label(fn($get) => 'Más solicitado (' . ($get('most_requested') ? 'Activo' : 'Inactivo') . ')')
                                    ->live()
                                    ->required()
                                    ->default(false),
                                Forms\Components\Toggle::make('trend')
                                    ->label(fn($get) => 'Tendencia (' . ($get('trend') ? 'Activo' : 'Inactivo') . ')')
                                    ->live()
                                    ->required()
                                    ->default(false),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make('Relaciones')
                            ->schema([
                                Forms\Components\Select::make('id_typevehicle')
                                    ->label('Tipo de vehículo')
                                    ->relationship(name: 'typevehicle', titleAttribute: 'name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('id_brand')
                                    ->label('Marca')
                                    ->relationship(name: 'brand', titleAttribute: 'name')
                                    ->searchable()
                                    ->preload()
                                    ->reactive() // Hace que este campo reaccione a cambios
                                    ->afterStateUpdated(
                                        fn($state, callable $set) =>
                                        $set(
                                            'nro_orden',
                                            $state
                                                ? (Product::where('id_brand', $state)->max('nro_orden') ?? 0) + 1
                                                : 1
                                        )
                                    ),
                                Forms\Components\TextInput::make('nro_orden')
                                    ->label('Nro Orden')
                                    ->numeric()
                                    ->required()
                                // ->disabled()
                                ,
                                Forms\Components\Select::make('id_brandvehicle')
                                    ->label('Marca de vehículo')
                                    ->relationship(name: 'brandvehicle', titleAttribute: 'name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\CheckboxList::make('id_category')
                                    ->label('Categorías')
                                    ->relationship(name: 'categories', titleAttribute: 'name')
                                    // ->searchable()
                                    // ->multiple()
                                    // ->preload()
                                    ->columns(2),
                                Forms\Components\CheckboxList::make('id_subcategory')
                                    ->label('Subcategorías')
                                    ->relationship(name: 'subcategories', titleAttribute: 'name')
                                    // ->searchable()
                                    // ->multiple()
                                    // ->preload()
                                    ->columns(2),
                                Forms\Components\Repeater::make('modellsproduct')
                                    ->label('Modelos')
                                    ->relationship('modellsproduct')
                                    ->schema([
                                        Forms\Components\Select::make('id_modell')
                                            ->label('Modelo')
                                            ->relationship(name: 'modell', titleAttribute: 'name')
                                            ->searchable()
                                            ->preload()
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('year_start')
                                            ->label('Año de inicio')
                                            ->numeric()
                                            ->required(),
                                        Forms\Components\TextInput::make('year_end')
                                            ->label('Año de fin')
                                            ->numeric()
                                            ->required(),
                                    ])
                                    ->columns(2),
                            ]),

                        // Forms\Components\Section::make('Asociaciones')
                        //     ->schema([
                        //         Forms\Components\CheckboxList::make('id_category')
                        //             ->label('Categorías')
                        //             ->relationship(name: 'categories', titleAttribute: 'name')
                        //             // ->searchable()
                        //             // ->multiple()
                        //             // ->preload()
                        //             ->columns(2),
                        //         Forms\Components\CheckboxList::make('id_subcategory')
                        //             ->label('Subcategorías')
                        //             ->relationship(name: 'subcategories', titleAttribute: 'name')
                        //             // ->searchable()
                        //             // ->multiple()
                        //             // ->preload()
                        //             ->columns(2),

                        //     ]),
                    ])->columnSpan(['lg' => 1]),

            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                // id
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('img')
                    ->disk('public')
                    // ->getStateUsing(function (Product $record) {
                    //     $baseUrlImage = 'http://localhost/app/';
                    //     return $baseUrlImage . $record->img;
                    // })
                    ->label('Imagen'),
                // Tables\Columns\ImageColumn::make('img')
                //     ->label('Imagen')
                //     ->getStateUsing(fn($record) => asset('storage/' . $record->img)),
                Tables\Columns\TextColumn::make('nro_orden')
                    ->label('Nro Orden')
                    ->alignCenter()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('description_general')
                    ->label('Descripción general')
                    ->html()
                    ->limit(20)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Categorías')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList(),

                // subcategories
                Tables\Columns\TextColumn::make('subcategories.name')
                    ->label('Subcategorías')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList(),

                Tables\Columns\TextColumn::make('typevehicle.name')
                    ->label('Tipo de vehículo')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Marca')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('brandvehicle.name')
                    ->label('Marca de vehículo')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                // ->sortable()
                ,
                Tables\Columns\TextColumn::make('price')
                    ->label('Precio')
                    ->money()
                // ->sortable()
                ,
                Tables\Columns\TextColumn::make('front_lift')
                    ->label('Front Lift')
                // ->searchable()
                ,
                Tables\Columns\TextColumn::make('rear_lift')
                    ->label('Rear Lift')
                    ->searchable(),
                Tables\Columns\TextColumn::make('discount')
                    ->label('Descuento')
                    ->numeric()
                // ->sortable()
                // ->toggleable(isToggledHiddenByDefault: true)
                ,
                // Tables\Columns\TextColumn::make('lift')
                //     ->searchable()
                //     ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('most_requested')
                    ->label('Más solicitado')
                    ->boolean()
                // ->sortable()
                // ->toggleable(isToggledHiddenByDefault: true)
                ,

                Tables\Columns\IconColumn::make('trend')
                    ->label('Tendencia')
                    ->boolean()
                // ->sortable()
                // ->toggleable(isToggledHiddenByDefault: true)
                ,

                Tables\Columns\IconColumn::make('state')
                    ->label('Estado')
                    ->boolean()
                // ->sortable()
                ,

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime()
                    // ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de Actualización')
                    ->dateTime()
                    // ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                SelectFilter::make('id_brand')
                    ->label('Filtrar por Marca')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('id_brandvehicle')
                    ->label('Filtrar por Marca de Vehículo')
                    ->relationship('brandvehicle', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('id_category')
                    ->label('Filtrar por Categoría')
                    ->relationship('categories', 'name')
                    ->searchable()
                    ->preload(),

            ])

            // ->filters([
            //     QueryBuilder::make()
            //         ->constraints([
            //             TextConstraint::make('name')
            //                 ->label('Nombre'),
            //             TextConstraint::make('description_general')
            //                 ->label('Descripción general'),
            //             TextConstraint::make('categories.name')
            //                 ->label('Categoría'),
            //             TextConstraint::make('typevehicle.name')
            //                 ->label('Tipo de vehículo'),
            //             TextConstraint::make('brand.name')
            //                 ->label('Marca'),
            //             TextConstraint::make('brandvehicle.name')
            //                 ->label('Marca de vehículo'),
            //             NumberConstraint::make('price')
            //                 ->label('Precio')
            //                 ->icon('heroicon-m-currency-dollar'),
            //             NumberConstraint::make('discount')
            //                 ->label('Descuento')
            //                 ->icon('heroicon-m-currency-dollar'),
            //             NumberConstraint::make('stock'),
            //             TextConstraint::make('front_lift')
            //                 ->label('front_lift'),
            //             TextConstraint::make('rear_lift')
            //                 ->label('rear_lift'),
            //             BooleanConstraint::make('most_requested')
            //                 ->label('Más solicitado'),
            //             BooleanConstraint::make('trend')
            //                 ->label('Tendencia'),
            //             BooleanConstraint::make('state')
            //                 ->label('Estado'),

            //         ])
            //         ->constraintPickerColumns(3),
            // ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            // ->deferFilters()

            ->headerActions([])
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
            ImagesRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ProductStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
