<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceProviderResource\Pages;
use App\Filament\Resources\ServiceProviderResource\RelationManagers;
use App\Models\ServiceProvider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceProviderResource extends Resource
{
    protected static ?string $model = ServiceProvider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
         
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->downloadable(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->columnSpan(2)
                    ->maxLength(255),
                Forms\Components\TextInput::make('complete_address')
                    ->columnSpan(2)
                    ->maxLength(255),
                Forms\Components\TextInput::make('gender')
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('active'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('role')
                ->formatStateUsing(function ($record) {
                    return match ($record->role) {
                        '1' => 'Admin',
                        '2' => 'Provider',
                        '3' => 'Customer',
                        default => 'Unknown', // Fallback if role does not match
                    };
                }),
                Forms\Components\TextInput::make('service')
                ->formatStateUsing(function ($record) {
                    return match ($record->service) {
                        '1' => 'N/A',
                        '2' => 'Appliances Services',
                        '3' => 'Electrical Services',
                        '4' => 'Plumbing Services',
                        '5' => 'Mechanic Services',
                        default => 'Unknown', // Fallback if role does not match
                    };
                }),
                Forms\Components\Grid::make(columns: 3)->schema([
                Forms\Components\FileUpload::make('primary_id')
                    ->downloadable()
                    ->label('Primary ID'),
                Forms\Components\FileUpload::make('secondary_id')
                 ->downloadable()
                 ->label('Secondary ID'),
                Forms\Components\FileUpload::make('certification')
                   ->downloadable()
                   ->label('Certification'),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
             
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name')
                ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('complete_address')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('role')
                    // ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(function ($record) {
                        return match ($record->role) {
                            '1' => 'Admin',
                            '2' => 'Provider',
                            '3' => 'Customer',
                            default => 'Unknown', // Fallback if role does not match
                        };
                    }),
                Tables\Columns\TextColumn::make('service')
                ->formatStateUsing(function ($record) {
                    return match ($record->service) {
                        '1' => 'N/A',
                        '2' => 'Appliances Services',
                        '3' => 'Electrical Services',
                        '4' => 'Plumbing Services',
                        '5' => 'Mechanic Services',
                        default => 'Unknown', // Fallback if role does not match
                    };
                })
                    ->searchable(),
                Tables\Columns\ImageColumn::make('primary_id')
                ->label('Primary ID'),
                Tables\Columns\ImageColumn::make('secondary_id')
                ->label('Secondary ID'),
                Tables\Columns\ImageColumn::make('certification'),
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
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListServiceProviders::route('/'),
            // 'create' => Pages\CreateServiceProvider::route('/create'),
            // 'edit' => Pages\EditServiceProvider::route('/{record}/edit'),
        ];
    }
}
