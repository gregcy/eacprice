<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TariffResource\Pages;
use App\Filament\Resources\TariffResource\RelationManagers;
use App\Models\Tariff;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;

class TariffResource extends Resource
{
    protected static ?string $model = Tariff::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dates')->schema ([
                    Forms\Components\DatePicker::make('start_date')
                        ->required(),
                    Forms\Components\DatePicker::make('end_date'),
                ])->columns(2),
                Forms\Components\Section::make('Code')->schema ([
                    Forms\Components\Select::make('code')
                    ->options(['01' => '01 - Single Rate Domestic Use', '02' => '02 - Two Rate Domestic Use', '08' => '08 - Special Rate for Vunerable Customers'])
                    ->required()
                    ->default(fn ($record) => $record->code ?? '01'),
                ])->columns(1),
                Forms\Components\Section::make('Recurring Charges')->schema ([
                    Forms\Components\TextInput::make('recurring_supply_charge')
                        ->numeric(),
                    Forms\Components\TextInput::make('recurring_meter_reading')
                        ->numeric(),
                ])->columns(2),
                Forms\Components\Section::make('Normal Charges')->schema ([
                    Forms\Components\TextInput::make('energy_charge_normal')
                        ->numeric(),
                    Forms\Components\TextInput::make('network_charge_normal')
                        ->numeric(),
                    Forms\Components\TextInput::make('ancillary_services_normal')
                        ->numeric(),
                ])->columns(3),
                Forms\Components\Section::make('Reduced Charges')->schema ([
                    Forms\Components\TextInput::make('energy_charge_reduced')
                        ->numeric(),
                    Forms\Components\TextInput::make('network_charge_reduced')
                        ->numeric(),
                    Forms\Components\TextInput::make('ancillary_services_reduced')
                        ->numeric(),
                ])->columns(3),
                Forms\Components\Section::make('Subsidised Charges')->schema ([
                    Forms\Components\TextInput::make('energy_charge_subsidy_first')
                        ->numeric(),
                    Forms\Components\TextInput::make('energy_charge_subsidy_second')
                        ->numeric(),
                    Forms\Components\TextInput::make('energy_charge_subsidy_third')
                        ->numeric(),
                    Forms\Components\TextInput::make('supply_subsidy_first')
                        ->numeric(),
                    Forms\Components\TextInput::make('supply_subsidy_second')
                        ->numeric(),
                    Forms\Components\TextInput::make('supply_subsidy_third')
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
                    ->placeholder('Current')
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('source_name')
                    ->searchable(),
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
            'index' => Pages\ListTariffs::route('/'),
            'create' => Pages\CreateTariff::route('/create'),
            'edit' => Pages\EditTariff::route('/{record}/edit'),
        ];
    }
}
