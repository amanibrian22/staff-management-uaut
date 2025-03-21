<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('email')->email()->required()->maxLength(255)->unique(),
            TextInput::make('password')->password()->required()->minLength(8)->confirmed(),
            TextInput::make('password_confirmation')->password()->required()->label('Confirm Password'),
            Select::make('role')
                ->label('Role')
                ->options([
                    'staff' => 'Staff',
                    'technical' => 'Technical',
                    'financial' => 'Financial',
                ])
                ->required()
                ->default('staff'),
        ];
    }

    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $allowedRoles = ['staff', 'technical', 'financial'];
        $data['role'] = in_array($data['role'], $allowedRoles) ? $data['role'] : 'staff';
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return '/login'; // Adjust if panel-specific login is needed
    }
}