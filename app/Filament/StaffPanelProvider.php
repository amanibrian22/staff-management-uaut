<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use App\Filament\Pages\Register; // Add this
use App\Filament\Pages\StaffPage;
use App\Filament\Pages\TechnicalPage;

class StaffPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('staff')
            ->path('staff')
            ->brandColor('#3B82F6') // Blue color
        ->secondaryColor('#F59E0B') // Yellow color
        ->brandLogo(asset('../../public/img/uaut-logo.png')) // Add the logo
        ->brandLogoHeight('3rem') // Set the logo height
        ->brandName('Staff Risk Management') // Add a brand name
        ->favicon(asset('images/favicon.ico')) // Add a favicon
            ->login()
            ->registration(Register::class) // Enable custom registration
            ->pages([
                StaffPage::class,
                TechnicalPage::class, // Remove if not intended here
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages');
    }
}