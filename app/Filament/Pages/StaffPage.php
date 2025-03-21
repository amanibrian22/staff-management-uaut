<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Notifications\Notification;
use App\Models\Risk;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StaffPage extends Page
{
    protected static string $view = 'filament.pages.staff-page';
    protected static ?string $slug = 'staff';
    protected static ?string $navigationLabel = 'Report Risks';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static bool $shouldRegisterNavigation = true;

    public $description = '';
    public $type = '';

    public function submit(): void
    {
        $this->validate([
            'description' => 'required|string',
            'type' => 'required|in:financial,technical',
        ]);

        $risk = Risk::create([
            'reported_by' => Auth::id(),
            'description' => $this->description,
            'type' => $this->type,
            'status' => 'pending',
            'assigned_to' => $this->assignToDepartment($this->type),
        ]);

        Notification::make()
            ->title('Risk reported successfully!')
            ->success()
            ->send();

        $this->reset(['description', 'type']);
    }

    private function assignToDepartment($type): ?int
    {
        $departmentRole = $type === 'financial' ? 'financial' : 'technical';
        return User::where('role', $departmentRole)->first()->id ?? null;
    }

    public static function canAccess(): bool
    {
        return Auth::user()->role === 'staff';
    }

    public function getTitle(): string
    {
        return 'Staff Risk Reporting';
    }

    public function getHeading(): string
    {
        return 'Report a Risk';
    }
}