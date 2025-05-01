<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use App\Http\Controllers\Auth\LoginController;

class FinancialPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('financial')
            ->path('staff/financial')
            ->login(LoginController::class)
            ->logoutUrl(route('staff.logout'))
            ->pages([
                \App\Filament\Pages\FinancialPage::class, // Adjust if exists
            ])
            ->authGuard('web')
            ->middleware(['web'])
            ->authMiddleware(['auth']);
    }
}