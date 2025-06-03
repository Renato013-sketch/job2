<?php

namespace App\Filament\Resources\AssetLendingResource\Pages;

use App\Filament\Resources\AssetLendingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssetLending extends EditRecord
{
    protected static string $resource = AssetLendingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
