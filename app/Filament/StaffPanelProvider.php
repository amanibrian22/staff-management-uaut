<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;

class StaffPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('staff')
            ->path('staff')
            ->login(\App\Http\Controllers\Auth\LoginController::class) // Point to your custom login
            ->pages([
                \App\Filament\Pages\StaffPage::class,
                \App\Filament\Pages\TechnicalPage::class,
                \App\Filament\Pages\AcademicPage::class,
                // Add other pages as needed
            ])
            ->authGuard('web') // Ensure it uses the default guard
            ->middleware(['web'])
            ->authMiddleware(['auth']);
    }
}