<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use App\Filament\Pages\Register; // Must be imported
use App\Filament\Pages\StaffPage;
use App\Filament\Pages\TechnicalPage;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('') // Root path for /register, /staff, /technical
            ->login()
            ->registration(Register::class) // Custom registration page
            ->pages([
                StaffPage::class,
                TechnicalPage::class,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages');
    }
}