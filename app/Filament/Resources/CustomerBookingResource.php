<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CustomerBooking;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Mokhosh\FilamentRating\RatingTheme;
use Illuminate\Database\Eloquent\Builder;
use Mokhosh\FilamentRating\Components\Rating;
use Mokhosh\FilamentRating\Columns\RatingColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerBookingResource\Pages;
use App\Models\MyBooking; 
use App\Filament\Resources\CustomerBookingResource\RelationManagers;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;

class CustomerBookingResource extends Resource
{
    protected static ?string $model = CustomerBooking::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
         
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->columnSpan(2)
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
                Select::make('approval')
                    ->label('Approval')
                    ->options([
                        'approved' => 'Approved',
                        'pending' => 'Pending',
                        'rejected' => 'Rejected',
                    ])
                    ->placeholder('Pending'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->columnSpan(2)
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
             
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name')
                ->limit(25)
                ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('approval')
                // ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('complete_address')
                ->limit(15)
                    ->searchable(),
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
                Tables\Actions\ViewAction::make(),
                Action::make('accept')
                    ->label('Accept')
                    ->icon('heroicon-o-check-circle')
                    ->action(function (CustomerBooking $record) {
                        // Update the approval status in CustomerBooking
                        $record->update(['approval' => 'approved']);
                        
                        // Find the corresponding MyBooking entry
                        $myBooking = MyBooking::where('user_id', $record->user_id) // Assuming you relate by user_id
                            ->where('service', $record->service) // or any other matching criteria
                            ->first();
            
                        // Update the approval status in MyBooking if it exists
                        if ($myBooking) {
                            $myBooking->update(['approval' => 'approved']);
                        }
            
                        // Optionally, notify the user
                        Notification::make()
                            ->title('Booking Accepted')
                            ->success()
                            ->send();
            
                        // Redirect to the index page
                        return redirect()->route('filament.admin.resources.customer-bookings.index');
                    })
                    ->requiresConfirmation() // Optional confirmation
                    ->color('success') // Optional color styling
                    ->size('lg'), // Adjust size to large
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle') // Optional: add an icon
                    ->action(function (CustomerBooking $record) {
                        // Update the approval status in CustomerBooking
                        $record->update(['approval' => 'rejected']);
                        
                        // Find the corresponding MyBooking entry
                        $myBooking = MyBooking::where('user_id', $record->user_id) // Assuming you relate by user_id
                            ->where('service', $record->service) // or any other matching criteria
                            ->first();
            
                        // Update the approval status in MyBooking if it exists
                        if ($myBooking) {
                            $myBooking->update(['approval' => 'rejected']);
                        }
            
                        // Optionally, notify the user
                        Notification::make()
                            ->title('Booking Rejected')
                            ->success()
                            ->send();
            
                        // Redirect to the index page
                        return redirect()->route('filament.admin.resources.customer-bookings.index');
                    })
                    ->requiresConfirmation() // Optional confirmation
                    ->color('danger') // Optional color styling
                    ->size('lg'), // Adjust size to large
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
            'index' => Pages\ListCustomerBookings::route('/'),
            'create' => Pages\CreateCustomerBooking::route('/create'),
            'edit' => Pages\EditCustomerBooking::route('/{record}/edit'),
        ];
    }
}
