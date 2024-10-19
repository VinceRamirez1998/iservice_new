<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TermsAndConditions extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.terms-and-conditions';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Terms & Conditions';

    protected static ?string $slug = 'terms-and-conditions';


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
        if (in_array($role, ['2', '3'])) {
            // Show navigation for roles '2' and '3'
            return true;
        } elseif ($role == '1') {
            // Perform action for role '1' (e.g., hide the navigation)
            return false;
        }
    
        // If role is not '1', '2', or '3', default to hiding navigation
        return false;
    }
    
    
}

