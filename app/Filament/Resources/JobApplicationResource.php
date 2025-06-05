<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobApplicationResource\Pages;
use App\Filament\Resources\JobApplicationResource\RelationManagers;
use App\Models\JobApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use App\Models\User;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::id()),
                Forms\Components\DatePicker::make('tanggal_lamar')
                    ->label('Application Date')
                    ->required()
                    ->native(false),
                Forms\Components\TextInput::make('nama_perusahaan')
                    ->label('Company Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat_perusahaan')
                    ->label('Company Address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('posisi')
                    ->label('Position')
                    ->label('Position')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('range_gaji')
                    ->label('Salary Range')
                    ->required()
                    ->numeric()
                    ->minValue(3000000)
                    ->validationMessages([
                        'minValue' => 'The salary range must be at least Rp 3,000,000.',
                    ])
                    ->maxLength(8),
                Forms\Components\Select::make('status')
                    ->options([
                        'applied' => 'Applied',
                        'interviewed' => 'Interviewed',
                        'offered' => 'Offered',
                        'rejected' => 'Rejected',
                    ])
                    ->label('Status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->recordUrl(null)
            ->recordAction(null)
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_lamar')
                    ->label('Application Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_perusahaan')
                    ->label('Company Name')
                    ->searchable()
                    ->copyable()
                    ->copyMessageDuration(1000)
                    ->tooltip('Copy Company Name'),
                Tables\Columns\TextColumn::make('alamat_perusahaan')
                    ->label('Company Address')
                    ->searchable()
                    ->copyable()
                    ->copyMessageDuration(1000)
                    ->tooltip('Click to copy address'),
                Tables\Columns\TextColumn::make('posisi')
                    ->label('Position')
                    ->searchable(),
                Tables\Columns\TextColumn::make('range_gaji')
                    ->label('Salary Range')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->searchable()
                    ->color(fn ($state) => match ($state) {
                        'applied' => 'primary',
                        'interviewed' => 'info',
                        'offered' => 'success',
                        'rejected' => 'danger',
                    }),
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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'applied' => 'Applied',
                        'interviewed' => 'Interviewed',
                        'offered' => 'Offered',
                        'rejected' => 'Rejected',
                    ])
                    ->label('Filter by Status'),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->tooltip('View Job Application Details'),
                    Tables\Actions\EditAction::make()
                        ->tooltip('Edit Job Application'),
                    Tables\Actions\DeleteAction::make()
                        ->tooltip('Delete Job Application')
                        ->color('danger'),
                ])
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
                Infolists\Components\Section::make('Job Application Details')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('tanggal_lamar')
                                    ->label('Application Date')
                                    ->date(),
                                Infolists\Components\TextEntry::make('nama_perusahaan')
                                    ->label('Company Name'),
                                Infolists\Components\TextEntry::make('alamat_perusahaan')
                                    ->label('Company Address')
                                    ->copyable()
                                    ->copyMessageDuration(1000)
                                    ->tooltip('Click to copy address'),
                                Infolists\Components\TextEntry::make('posisi')
                                    ->label('Position'),
                                Infolists\Components\TextEntry::make('range_gaji')
                                    ->label('Salary Range')
                                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                                Infolists\Components\TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn ($state) => match ($state) {
                                        'applied' => 'primary',
                                        'interviewed' => 'info',
                                        'offered' => 'success',
                                        'rejected' => 'danger',
                                    }),
                            ]),
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
            'index' => Pages\ListJobApplications::route('/'),
//            'create' => Pages\CreateJobApplication::route('/create'),
//            'edit' => Pages\EditJobApplication::route('/{record}/edit'),
        ];
    }
    protected static function getNavigationQuery(): Builder
    {
    return static::getEloquentQuery()->where('user_id', Auth::id());
    }

public static function getEloquentQuery(): Builder
    {
    return parent::getEloquentQuery()->where('user_id', Auth::id());
    }
}
