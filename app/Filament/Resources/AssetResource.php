<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetResource\Pages;
use App\Filament\Resources\AssetResource\RelationManagers;
use App\Models\Asset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions;
use Filament\Tables\Actions\BulkActionGroup;
use Laravel\SerializableClosure\Serializers\Native;
use OpenSpout\Reader\Common\ColumnWidth;
use Filament\Infolists\Infolist;
use Filament\Infolists;
class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Asset';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('asset_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('serial_number')
                    ->maxLength(255),
                Forms\Components\Select::make('cond')
                    ->options([
                        'Good' => 'Good',
                        'Fair' => 'Fair',
                        'Bad' => 'Bad',
                    ])
                    ->required()
                    ->label('Condition')
                    ->native(true)
                    ->searchable(),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->recordAction(null)
            ->columns([
                Tables\Columns\TextColumn::make('asset_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('serial_number')
                    ->tooltip('Click to copy')
                    ->searchable()
                    ->copyable()
                    ->copyMessageDuration(1000),
                Tables\Columns\TextColumn::make('cond')
                    ->label('Condition')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Good' => 'success',
                        'Fair' => 'warning',
                        'Bad' => 'danger',
                            })
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchaseqty')
                    ->label('Purchase Quantity')
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
                Tables\Actions\ViewAction::make()
                    ->tooltip('View Asset Details'),
                Tables\Actions\EditAction::make()
                    ->tooltip('Edit Asset'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('asset_name')
                    ->label('Asset Name'),
                Infolists\Components\TextEntry::make('serial_number')
                    ->label('Serial Number'),
                Infolists\Components\TextEntry::make('cond')
                    ->label('Condition'),
                Infolists\Components\TextEntry::make('created_at')
                    ->dateTime()
                    ->label('Created At'),
                Infolists\Components\TextEntry::make('updated_at')
                    ->dateTime()
                    ->label('Updated At'),
                Infolists\Components\TextEntry::make('purchaseqty')
                    ->label('Purchase Quantity'),
            ])
            ->columns(3);
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
            'index' => Pages\ListAssets::route('/'),
//            'create' => Pages\CreateAsset::route('/create'),
//            'edit' => Pages\EditAsset::route('/{record}/edit'),
        ];
    }
}
