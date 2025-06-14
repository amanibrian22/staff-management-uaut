<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use App\Http\Controllers\Auth\LoginController;

class StaffPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('staff')
            ->path('staff/staff')
            ->login(LoginController::class)
            ->logoutUrl(route('staff.logout')) // Use route name
            ->pages([
                \App\Filament\Pages\StaffPage::class,
            ])
            ->authGuard('web')
            ->middleware(['web'])
            ->authMiddleware(['auth']);
    }
}