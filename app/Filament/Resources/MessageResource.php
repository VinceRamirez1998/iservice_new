<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Filament\Resources\MessageResource\RelationManagers;
use App\Models\Message;
use App\Models\User;
use App\Models\MyBooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Http\Resources\Json\JsonResource;


class MessageResource extends JsonResource
{
    protected static ?string $model = Message::class;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sender_id')
                    ->label('Sender')
                    ->required()
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Select Sender'),

                Forms\Components\Select::make('receiver_id')
                    ->label('Receiver')
                    ->required()
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Select Receiver'),

                Forms\Components\Select::make('booking_id')
                    ->label('Booking')
                    ->required()
                    ->options(MyBooking::all()->pluck('id', 'id'))
                    ->searchable()
                    ->placeholder('Select Booking'),

                Forms\Components\Textarea::make('content')
                    ->label('Message Content')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sender.name')
                    ->label('Sender')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('receiver.name')
                    ->label('Receiver')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('booking_id')
                    ->sortable()
                    ->label('Booking ID'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created At')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Updated At')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Custom Message Button
                Action::make('message')
                    ->label('Message')
                    ->icon('heroicon-o-envelope')
                    ->url(fn (Message $record) => route('message.user', ['userId' => $record->receiver_id, 'bookingId' => $record->booking_id]))
                    ->color('primary'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMessages::route('/'),
            'create' => Pages\CreateMessage::route('/create'),
            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
