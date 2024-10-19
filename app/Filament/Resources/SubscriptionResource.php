<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Subscription;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;
use App\Filament\Resources\SubscriptionResource\Widgets\SubscriptionOverview;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Invoice';
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
        if (in_array($role, ['1','2'])) {
            // Show navigation for roles '2' and '3'
            return true;
        } elseif ($role == '3') {
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
                ->downloadable()
                ->columnSpan(2)
                ->label('Receipt'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'approved' => 'Approved',
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'deactivated' => 'Deactivated',
                    ])
                    ->disabled(),
                Forms\Components\TextInput::make('reference_no')
                    ->required()
                    ->maxLength(255),
                    Select::make('bank')
                    ->label('Bank')
                    ->options([
                        'gcash' => 'Gcash | 0956-421-2344 ',
                        'maya' => 'Maya | 0956-421-2344',
                        'unionbank' => 'Union Bank | 0956-421-2344',
                        'bpi' => 'BPI | 0956-421-2344',
                        'bdo' => 'BDO | 0956-421-2344',
                        'seabank' => 'Sea Bank | 0956-421-2344',
                        'landbank' => 'Land Bank | 0956-421-2344',
                    ]),
                Select::make('subscription_plan')
                ->label('Subscription Plan')
                ->options([
                    'trial' => 'Trial',
                    '1month' => '1 Month Plan',
                    '3months' => '3 Months Plan',
                    '6months' => '6 Months Plan',
                    '1year' => '1 Year Plan',
                ])
                ->reactive() // Make it reactive
                ->afterStateUpdated(function ($state, callable $set) {
                    // Update subscription_duration based on selected plan
                    switch ($state) {
                        case '1month':
                            $set('subscription_duration', now()->addMonth()->toDateString());
                            break;
                        case '3months':
                            $set('subscription_duration', now()->addMonths(3)->toDateString());
                            break;
                        case '6months':
                            $set('subscription_duration', now()->addMonths(6)->toDateString());
                            break;
                        case '1year':
                            $set('subscription_duration', now()->addYear()->toDateString());
                            break;
                        case 'no_subscription':
                            $set('subscription_duration', 'No Subscription');
                            break;
                           
                    } 
                }),
            Forms\Components\TextInput::make('subscription_duration')
                ->label('Subscription Expiration Date')
                ->maxLength(255)
                ->disabled(),
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reference_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank')
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

    public static function getWidgets(): array
    {
        return [
            SubscriptionOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
