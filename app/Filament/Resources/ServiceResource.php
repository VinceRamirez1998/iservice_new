<?php

namespace App\Filament\Resources;

use App\Models\Service;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\ServiceResource\Pages;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?int $navigationSort = -3;
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Providers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(columns: 2)->schema([
                 
                    Forms\Components\FileUpload::make('image')
                        ->label('Service Image')
                        ->downloadable()
                        ->columnSpan(2),
                        // ->required() // Uncomment if required
                           // Service Name Input
                    TextInput::make('name')
                    ->label('Service Name')
                    ->maxLength(255)
                    ->columnSpan(2)
                    ->required(), // Uncomment if required

                // Image Upload
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              
                ImageColumn::make('image')
                    ->url(fn ($record) => Storage::url($record->image))
                    ->label('Image')
                    ->disk('public'),
                TextColumn::make('name')
                    ->searchable()
                    ->label('Service Name')
                    ->sortable(),

            ])
            ->filters([/* Define any filters here */])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [/* Define any relations here */];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
