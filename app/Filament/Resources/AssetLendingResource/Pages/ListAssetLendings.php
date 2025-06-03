<?php

namespace App\Filament\Resources\AssetLendingResource\Pages;

use App\Filament\Resources\AssetLendingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssetLendings extends ListRecords
{
    protected static string $resource = AssetLendingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Asset Lending')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->tooltip('Add a new asset lending'),
        ];
    }
}
