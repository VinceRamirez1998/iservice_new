<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ServiceProvider;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Mokhosh\FilamentRating\RatingTheme;
use Illuminate\Database\Eloquent\Builder;
use Mokhosh\FilamentRating\Components\Rating;
use Mokhosh\FilamentRating\Columns\RatingColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ServiceProviderResource\Pages;
use App\Filament\Resources\ServiceProviderResource\RelationManagers;

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
                Select::make('subscription_plan')
                ->label('Subscription Plan')
                ->options([
                    '1month' => '1 Months Plan',
                    '3months' => '3 Months Plan',
                    '6months' => '6 Months Plan',
                    '1year' => '1 Year Plan',
                    '2year' => '2 Years Plan',
                ]),
                Forms\Components\TextInput::make('subscription_duration')
                ->label('Subscription Duration')
                    ->maxLength(255)
                    ->disabled(),
                    Rating::make('rating') // Add the rating field
                    ->theme(RatingTheme::Simple) // You can choose a theme
                    ->stars(5) // Set the maximum stars
                    ->allowZero() // Allow zero stars if desired
                    ->size('md') // Set the size of the stars
                    ->color('primary') // Customize the color
                    ->default(0), // Make sure to set a default if needed
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
                    RatingColumn::make('rating') // Add the rating column
                    ->label('User Rating') // Optional label
                    ->sortable(), // Make it sortable if needed
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