<?php

namespace App\Filament\Resources\PurchasedAssetResource\Pages;

use App\Filament\Resources\PurchasedAssetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchasedAssets extends ListRecords
{
    protected static string $resource = PurchasedAssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Purchased Asset')
            ->icon('heroicon-o-plus')
            ->tooltip('Add Purchased Asset'),
        ];
    }
}
