<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Notifications\Notification;
use App\Models\Risk;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TechnicalPage extends Page
{
    protected static string $view = 'filament.pages.technical-page';
    protected static ?string $slug = 'technical'; // Ensures /technical URL
    protected static ?string $navigationLabel = 'Technical Risks';
    protected static ?string $navigationIcon = 'heroicon-o-wrench';
    protected static bool $shouldRegisterNavigation = true;

    public $response = '';
    public $status = '';
    public $selectedRiskId = null;

    public function mount(): void
    {
        $this->resetForm();
    }

    public function getRisks()
    {
        return Risk::where('assigned_to', Auth::id())->get();
    }

    public function selectRisk($riskId): void
    {
        $this->selectedRiskId = $riskId;
        $risk = Risk::find($riskId);
        $this->response = $risk->response ?? '';
        $this->status = $risk->status;
    }

    public function submit(): void
    {
        $this->validate([
            'response' => 'required|string',
            'status' => 'required|in:pending,in_progress,resolved',
        ]);

        $risk = Risk::find($this->selectedRiskId);
        if ($risk && $risk->assigned_to === Auth::id()) {
            $risk->update([
                'response' => $this->response,
                'status' => $this->status,
            ]);

            Notification::make()
                ->title('Risk updated successfully!')
                ->success()
                ->send();
        }

        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->response = '';
        $this->status = '';
        $this->selectedRiskId = null;
    }

    public static function canAccess(): bool
    {
        return Auth::user()->role === 'technical';
    }

    public function getTitle(): string
    {
        return 'Technical Risk Management';
    }

    public function getHeading(): string
    {
        return 'Manage Technical Risks';
    }
}