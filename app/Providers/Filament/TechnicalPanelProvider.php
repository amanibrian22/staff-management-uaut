<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use App\Http\Controllers\Auth\LoginController;

class TechnicalPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('technical')
            ->path('staff/technical')
            ->login(LoginController::class)
            ->logoutUrl(route('staff.logout'))
            ->pages([
                \App\Filament\Pages\TechnicalPage::class,
            ])
            ->authGuard('web')
            ->middleware(['web'])
            ->authMiddleware(['auth']);
    }
}