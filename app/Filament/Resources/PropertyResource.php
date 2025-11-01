<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Propriétés';

    protected static ?string $modelLabel = 'Propriété';

    protected static ?string $pluralModelLabel = 'Propriétés';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations de la propriété')
                    ->description('Détails principaux de la propriété')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom de la propriété')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ex: Villa Moderne à Paris')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->rows(4)
                            ->placeholder('Décrivez les caractéristiques de la propriété...')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('price_per_night')
                            ->label('Prix par nuit (€)')
                            ->required()
                            ->numeric()
                            ->prefix('€')
                            ->minValue(0)
                            ->maxValue(99999.99)
                            ->step(0.01)
                            ->placeholder('150.00'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informations additionnelles')
                    ->description('Dates de création et mise à jour')
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Créé le')
                            ->content(fn (Property $record): ?string => $record->created_at?->format('d/m/Y H:i:s')),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Modifié le')
                            ->content(fn (Property $record): ?string => $record->updated_at?->format('d/m/Y H:i:s')),
                    ])
                    ->columns(2)
                    ->hidden(fn (?Property $record) => $record === null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->limit(50)
                    ->wrap()
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                Tables\Columns\TextColumn::make('price_per_night')
                    ->label('Prix / Nuit')
                    ->money('EUR')
                    ->sortable()
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('bookings_count')
                    ->label('Réservations')
                    ->counts('bookings')
                    ->badge()
                    ->color('success')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('expensive')
                    ->label('Prix élevé (> 200€)')
                    ->query(fn ($query) => $query->where('price_per_night', '>', 200)),

                Tables\Filters\Filter::make('affordable')
                    ->label('Abordable (< 100€)')
                    ->query(fn ($query) => $query->where('price_per_night', '<', 100)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('60s');
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
            'view' => Pages\ViewProperty::route('/{record}'),
        ];
    }
}
