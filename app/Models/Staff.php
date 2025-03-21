<?php

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable implements FilamentUser
{
    protected $guarded = [];

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return str($panel->getId())->contains('staff');
    }
}

