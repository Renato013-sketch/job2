<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchasedAssetResource\Pages;
use App\Filament\Resources\PurchasedAssetResource\RelationManagers;
use App\Models\PurchasedAsset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Asset;
use Filament\Tables\Columns\TextColumn;

class PurchasedAssetResource extends Resource
{
    protected static ?string $model = PurchasedAsset::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Asset';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('asset_id')
                    ->relationship('asset', 'asset_name')
                    ->required()
                    ->searchable()
                    ->options(Asset::all()->pluck('asset_name', 'id')),
                Forms\Components\TextInput::make('serial_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('qty')
                    ->numeric()
                    ->minValue(1)
                    ->required(),
                Forms\Components\DatePicker::make('purchase_date')
                ->native(false),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asset.asset_name')
                    ->searchable()
                    ->label('Asset Name'),
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qty')
                    ->sortable()
                    ->label('Quantity'),
                Tables\Columns\TextColumn::make('purchase_date')
                    ->date()
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
                Tables\Actions\EditAction::make()
                    ->tooltip('Edit Purchased Asset'),
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
            'index' => Pages\ListPurchasedAssets::route('/'),
//            'create' => Pages\CreatePurchasedAsset::route('/create'),
//            'edit' => Pages\EditPurchasedAsset::route('/{record}/edit'),
        ];
    }
}
