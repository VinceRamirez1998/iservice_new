<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Session; // Import the Session facade
use Illuminate\Support\Carbon; // Import Carbon for date handling

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
   
    public function create(bool $another = false): void
    {
        $data = $this->form->getState(); // Get form data

        // Set the subscription_duration based on the selected plan
        if (isset($data['subscription_plan'])) {
            $data['subscription_duration'] = $this->calculateDuration($data['subscription_plan']);
        }

        // Create the subscription using the model's create method
        User::create($data);

        // // Set a flash message
        // Session::flash('success', 'Subscription created successfully!');

        // Redirect to the index page after creation
        $this->redirect($this->getResource()::getUrl('index'));
    }

    public function cancel(): void
    {
        // Redirect to index on cancel
        $this->redirect($this->getResource()::getUrl('index'));
    }

    protected function calculateDuration(?string $plan): ?string
    {
        if (!$plan) {
            return null;
        }

        switch ($plan) {
            case '1month':
                return Carbon::now()->addMonth()->toDateString();
            case '3months':
                return Carbon::now()->addMonths(3)->toDateString();
            case '6months':
                return Carbon::now()->addMonths(6)->toDateString();
            case '1year':
                return Carbon::now()->addYear()->toDateString();
            default:
                return null; // Handle invalid plans
        }
    }
}
