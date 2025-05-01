<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use App\Http\Controllers\Auth\LoginController;

class AcademicPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('academic')
            ->path('staff/academic')
            ->login(LoginController::class)
            ->logoutUrl(route('staff.logout'))
            ->pages([
                \App\Filament\Pages\AcademicPage::class,
            ])
            ->authGuard('web')
            ->middleware(['web'])
            ->authMiddleware(['auth']);
    }
}