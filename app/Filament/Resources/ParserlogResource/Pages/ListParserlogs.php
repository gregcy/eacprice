<?php

namespace App\Filament\Resources\ParserlogResource\Pages;

use App\Filament\Resources\ParserlogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParserlogs extends ListRecords
{
    protected static string $resource = ParserlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
