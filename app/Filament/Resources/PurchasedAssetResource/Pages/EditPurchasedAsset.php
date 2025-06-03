<?php

namespace App\Filament\Resources\PurchasedAssetResource\Pages;

use App\Filament\Resources\PurchasedAssetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchasedAsset extends EditRecord
{
    protected static string $resource = PurchasedAssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
