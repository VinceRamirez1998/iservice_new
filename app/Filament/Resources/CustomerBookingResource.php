<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\MyBooking; 
use Filament\Tables\Table;
use App\Models\CustomerBooking;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\BulkAction;
use Mokhosh\FilamentRating\RatingTheme;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Mokhosh\FilamentRating\Components\Rating;
use Mokhosh\FilamentRating\Columns\RatingColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerBookingResource\Pages;
use App\Filament\Resources\CustomerBookingResource\RelationManagers;

class CustomerBookingResource extends Resource
{
    protected static ?string $model = CustomerBooking::class;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('user_id', Auth::id())->count();
    }
    
    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
    
        // If there is no authenticated user, return false
        if (!$user) {
            return false;
        }
    
        // Fetch the role of the authenticated user from the 'users' table
        $role = DB::table('users')
            ->where('id', $user->id)
            ->value('role'); // Get the role column value
    
        // Check if the role is '2' or '3', otherwise handle '1'
        if (in_array($role, ['2'])) {
            // Show navigation for roles '2' and '3'
            return true;
        } elseif ($role == '1') {
            // Perform action for role '1' (e.g., hide the navigation)
            return false;
        }
    
        // If role is not '1', '2', or '3', default to hiding navigation
        return false;
    }

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
                    Forms\Components\DateTimePicker::make('schedule')
                    ->columnSpan(2)
                    ->label('Booking Schedule')
                    ->default(Carbon::now()) // Default to current date and time
                    ->format('d-M-Y g:i A') // Format as 15-Sep-2024 5:04 PM
                    ->timezone('Asia/Manila') // Set the timezone
                    // ->default(Date::now()->timezone('Asia/Manila')->format('d-M-Y g:i A'))
                    ->disabled(),
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
                        
                        // Find the corresponding MyBooking entry by matching user_id and service_provider_id
                        $myBooking = MyBooking::where('user_id', $record->user_id)
                            ->where('service_provider_id', $record->service_provider_id) // Use service_provider_id for better accuracy
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
                    ->requiresConfirmation()
                    ->color('success')
                    ->size('lg'),
            
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->action(function (CustomerBooking $record) {
                        // Update the approval status in CustomerBooking
                        $record->update(['approval' => 'rejected']);
                        
                        // Find the corresponding MyBooking entry by matching user_id and service_provider_id
                        $myBooking = MyBooking::where('user_id', $record->user_id)
                            ->where('service_provider_id', $record->service_provider_id) // Use service_provider_id for better accuracy
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
                    ->requiresConfirmation()
                    ->color('danger')
                    ->size('lg'),
            
                Action::make('message')
                    ->label('Message')
                    ->icon('heroicon-o-envelope')
                    ->action(function (CustomerBooking $record) {
                        // Query the messages table for the relevant message
                        $messageData = DB::table('messages')
                            ->where('booking_id', $record->id)
                            ->first();
                    
                        // Ensure we have valid data for sender and receiver
                        if ($messageData) {
                            $senderId = $messageData->sender_id; // Sender ID from the message
                            $receiverId = $messageData->receiver_id; // Receiver ID from the message
                        } else {
                            // Fallback logic if no message exists
                            $senderId = auth()->id(); // Assume logged-in user is the sender
                            $receiverId = $record->user_id; // Get the receiver's ID from the CustomerBooking record
                        }
                    
                        $bookingId = $record->id; // Booking ID
                    
                        // Redirect to the desired message URL
                        return redirect()->route('message.user', [
                           'userId' => $receiverId, // Use the receiver's ID
                           'bookingId' => $bookingId  // Use the booking ID
                        ]);
                    })
            
                
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
