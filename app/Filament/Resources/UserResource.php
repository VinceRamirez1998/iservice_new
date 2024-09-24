<?php

namespace App\Filament\Resources;

use Log;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationGroup = 'Accounts';

    public static function form(Form $form): Form
    {
        return $form->schema([
        
            Forms\Components\Card::make()->schema([
                Forms\Components\Grid::make(columns: 2)->schema([
                    Forms\Components\FileUpload::make('image')
                    ->downloadable()
                    ->label('Image'),
                    Forms\Components\TextInput::make('name')->unique(ignoreRecord: true)->required()->maxLength(255)
                    ->label('Full Name')
                    ->columnSpan(2),
                    Select::make('service')
                    // ->multiple()
                    ->relationship('services', 'name')->preload(),
                    Forms\Components\TextInput::make('email')->unique(ignoreRecord: true)->email()->required()->maxLength(255),
                    Select::make('gender')
                    ->label('Gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ]),
                    TextInput::make('phone')
                    ->label('Contact No.')
                    ->maxLength(255),
                    Forms\Components\TextInput::make('password')
                    ->password()
                    ->unique()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (Page $livewire) => $livewire instanceof CreateUser)
                    ->maxLength(255),
                    Select::make('status')
                    ->label('Status')
                    ->options([
                        'approved' => 'Approved',
                        'reject' => 'Reject',
                        'pending' => 'Pending',
                    ])
                    ->placeholder('Pending'),
                    Forms\Components\DateTimePicker::make('created_at')
                    ->default(Carbon::now()) // Default to current date and time
                    ->format('d-M-Y g:i A') // Format as 15-Sep-2024 5:04 PM
                    ->timezone('Asia/Manila') // Set the timezone
                    // ->default(Date::now()->timezone('Asia/Manila')->format('d-M-Y g:i A'))
                    ->disabled(),
                    Forms\Components\DateTimePicker::make('updated_at')
                    // ->default(Date::now()->timezone('Asia/Manila')->format('d-M-Y g:i A'))
                    ->default(Carbon::now()) // Default to current date and time
                    ->format('d-M-Y g:i A') // Format as 15-Sep-2024 5:04 PM
                    ->timezone('Asia/Manila')// Set the timezone
                    ->disabled(),
                    Forms\Components\TextInput::make('complete_address')
                    // ->required()
                    ->columnSpan(2),
                        Select::make('role')
                            // ->required()
                            ->relationship('roles', 'name')->preload(),
                        Select::make('permission')
                            ->multiple()
                            ->relationship('permissions', 'name')->preload(),
                       
                        ]),

                   
                    Forms\Components\FileUpload::make('primary_id')
                        // ->required()
                        ->downloadable()
                        ->label('Primary ID'),
                    Forms\Components\FileUpload::make('secondary_id')
                        // ->required()
                        ->downloadable()
                        ->label('Secondary ID'),
                    Forms\Components\FileUpload::make('certification')
                        // ->required()
                        ->downloadable()
                        ->label('Certification'),
            ]),
        ]);
    }
    
    
        public static function table(Table $table): Table
        {

           
            return $table
                ->columns([
                  
                    Tables\Columns\ImageColumn::make('image')
                        ->url(fn ($record) => Storage::url($record->image))
                        ->label('Image')
                        ->disk('public'),
                    Tables\Columns\TextColumn::make('name')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('email')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('gender')
                        ->searchable()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('phone')
                        ->label('Contact No.')
                        ->searchable()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                   
                    Tables\Columns\TextColumn::make('updated_at')
                        ->dateTime('d-M-Y g:i A') // Format as 15-Sep-2024 5:04 PM
                        ->timezone('Asia/Manila') // Set the timezone
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('complete_address')
                    ->label('Complete Address')
                    ->searchable()
                    ->sortable(),
                        Tables\Columns\TextColumn::make('service') // Use the relationship name
                        ->formatStateUsing(function ($record) {
                            return ($record->services->isEmpty() || $record->services == null) ? 'N/A' : $record->services->pluck('name')->join(', ');
                        })
                        // ->default('N/A')
                        ->searchable()
                        ->sortable(),
                        Tables\Columns\TextColumn::make('role')
                        // ->toggleable(isToggledHiddenByDefault: true)
                        ->formatStateUsing(function ($record) {
                            return match ($record->role) {
                                '1' => 'Admin',
                                '2' => 'Provider',
                                '3' => 'Customer',
                                default => 'Unknown', // Fallback if role does not match
                            };
                        })
                        ->searchable()
                        ->sortable(),
                        Tables\Columns\SelectColumn::make('permission')
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                        Tables\Columns\ImageColumn::make('primary_id')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->url(fn ($record) => Storage::url($record->primary_id))
                        ->label('Primary ID')
                        ->disk('public'),
                        Tables\Columns\ImageColumn::make('secondary_id')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->url(fn ($record) => Storage::url($record->secondary_id))
                        ->label('Secondary ID')
                        ->disk('public'),
                        Tables\Columns\ImageColumn::make('certification')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->url(fn ($record) => Storage::url($record->certification))
                        ->label('Certification')
                        ->disk('public'),
                        Tables\Columns\TextColumn::make('created_at')
                        ->dateTime('d-M-Y g:i A') // Format as 15-Sep-2024 5:04 PM
                        ->timezone('Asia/Manila') // Set the timezone
                        ->sortable(),
                ])
                ->filters([
                    //
                ])
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('name','!=', 'admin');
    }

}
