<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use App\Models\Risk;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;

class AcademicPage extends Page implements HasTable
{
    use InteractsWithTable;
    protected static string $view = 'filament.pages.academic-page';
    protected static ?string $slug = 'academic'; // Matches /staff/academic
    protected static ?string $navigationLabel = 'Academic Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Risk::where('type', 'academic')
                    ->whereHas('reporter', fn ($query) => $query->where('role', 'staff'))
                    ->with('reporter')
            )
            ->columns([
                TextColumn::make('description')->label('Description'),
                TextColumn::make('reporter.name')->label('Reported By'),
                TextColumn::make('reporter.phone')->label('Reporter Phone'), // Staff phone number
                TextColumn::make('type')->label('Type')->formatStateUsing(fn ($state) => ucfirst($state)),
                TextColumn::make('status')->label('Status')->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'in_progress' => 'info',
                        'resolved' => 'success',
                        default => 'gray'
                    }),
                TextColumn::make('response')->label('Response')->default('No response yet'),
                TextColumn::make('created_at')->label('Reported On')->dateTime(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'resolved' => 'Resolved',
                    ]),
            ])
            ->actions([
                Action::make('resolve')
                    ->label('Resolve')
                    ->button()
                    ->color('success')
                    ->visible(fn (Risk $record) => $record->status !== 'resolved')
                    ->action(function (Risk $record) {
                        $record->update([
                            'status' => 'resolved',
                            'response' => 'Issue resolved by ' . Auth::user()->name . ' (Phone: ' . Auth::user()->phone . ')', // Academic phone
                        ]);
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Resolve Risk')
                    ->modalDescription('Are you sure you want to mark this risk as resolved?')
                    ->modalSubmitActionLabel('Yes, resolve it'),
            ]);
    }

    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->role === 'academic';
    }

    public function getTitle(): string
    {
        return 'Academic Risk Overview';
    }

    public function getHeading(): string
    {
        return 'Academic Risks Reported by Staff';
    }
}