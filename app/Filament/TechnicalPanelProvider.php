<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use App\Filament\Pages\TechnicalPage;

class TechnicalPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('technical')
            ->path('technical')
            ->login() // Ensures default login page
            ->pages([
                TechnicalPage::class,
            ]);
    }
}