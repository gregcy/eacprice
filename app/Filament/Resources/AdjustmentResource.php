<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdjustmentResource\Pages;
use App\Filament\Resources\AdjustmentResource\RelationManagers;
use App\Models\Adjustment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;


class AdjustmentResource extends Resource
{
    protected static ?string $model = Adjustment::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $modelLabel = 'Fuel Adjustment';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dates')->schema ([
                    Forms\Components\DatePicker::make('start_date')
                        ->required(),
                    Forms\Components\DatePicker::make('end_date')
                        ->required(),
                ])->columns(2),
                Forms\Components\Section::make('Options')->schema ([
                    Forms\Components\Select::make('consumer_type')
                        ->options(['Monthly' => 'Monthly', 'Bi-Monthly' => 'Bi-Monthly'])
                        ->required()
                        ->default(fn ($record) => $record->consumer_type ?? 'Monthly'),
                    Forms\Components\Select::make('voltage_type')
                        ->options(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'])
                        ->default(fn ($record) => $record->consumer_type ?? 'Low')
                        ->required(),
                ])->columns(2),
                Forms\Components\Section::make('Calculation Parameters')->schema ([
                    Forms\Components\TextInput::make('weighted_average_fuel_price')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('fuel_adjustment_coefficient')
                        ->required()
                        ->numeric(),
                ])->columns(2),
                Forms\Components\Section::make('Adjustment Prices')->schema ([
                    Forms\Components\TextInput::make('total')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('fuel')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('co2_emissions')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('cosmos')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('revised_fuel_adjustment_price')
                        ->numeric(),
                ])->columns(3),
                Forms\Components\Section::make('Source')->schema ([
                    Forms\Components\TextInput::make('source')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('source_name')
                        ->required()
                        ->maxLength(255),
                ])->columns(2),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric(decimalPlaces: 6)
                    ->sortable(),
                Tables\Columns\TextColumn::make('revised_fuel_adjustment_price')
                    ->label('Revised')
                    ->numeric(decimalPlaces: 6)
                    ->sortable(),
                Tables\Columns\TextColumn::make('fuel')
                    ->numeric(decimalPlaces: 6)
                    ->sortable(),
                Tables\Columns\TextColumn::make('co2_emissions')
                    ->label('CO2')
                    ->numeric(decimalPlaces: 6)
                    ->sortable(),
                Tables\Columns\TextColumn::make('cosmos')
                    ->numeric(decimalPlaces: 6)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_date', 'desc');
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
            'index' => Pages\ListAdjustments::route('/'),
            'create' => Pages\CreateAdjustment::route('/create'),
            'edit' => Pages\EditAdjustment::route('/{record}/edit'),
        ];
    }
}
