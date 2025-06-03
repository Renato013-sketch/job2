<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetLendingResource\Pages;
use App\Filament\Resources\AssetLendingResource\RelationManagers;
use App\Models\AssetLending;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssetLendingResource extends Resource
{
    protected static ?string $model = AssetLending::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Asset';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date_lending')
                    ->required()
                    ->native(false)
                    ->placeholder('Select date of lending'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('asset_id')
                    ->relationship('asset', 'asset_name')
                    ->required()
                    ->native(true)
                    ->searchable(),
                Forms\Components\TextInput::make('qty')
                    ->required()
                    ->numeric()
                    ->placeholder('Enter quantity')
                    ->maxLength(255),
                Forms\Components\TextInput::make('note')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_lending')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('asset.asset_name')
                    ->label('Asset Name')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qty')
                    ->searchable(),
                Tables\Columns\TextColumn::make('note')
                    ->searchable(),
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
                    ->tooltip('Edit Asset Lending'),
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
            'index' => Pages\ListAssetLendings::route('/'),
//            'create' => Pages\CreateAssetLending::route('/create'),
//            'edit' => Pages\EditAssetLending::route('/{record}/edit'),
        ];
    }
}
