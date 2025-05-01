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
    protected static ?string $navigationLabel = 'Staff Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public $description = '';
    public $type = '';

    public function mount(): void
    {
        $this->reset(['description', 'type']);
    }

    public function submit(): void
    {
        $this->validate([
            'description' => 'required|string',
            'type' => 'required|in:technical,financial,academic', // Added "academic"
        ]);

        $assignee = User::where('role', $this->type)->inRandomOrder()->first();

        Risk::create([
            'reported_by' => Auth::id(),
            'description' => $this->description,
            'type' => $this->type,
            'status' => 'pending',
            'assigned_to' => $assignee ? $assignee->id : null,
        ]);

        Notification::make()
            ->title('Risk reported successfully!')
            ->success()
            ->send();

        $this->reset(['description', 'type']);
    }

    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->role === 'staff';
    }

    public function getTitle(): string
    {
        return 'Staff Risk Reporting';
    }

    public function getHeading(): string
    {
        return 'Report and Track Risks';
    }
}