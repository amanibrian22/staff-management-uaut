<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Risk;
use Illuminate\Support\Facades\Auth;

class StaffPage extends Component
{
    public $description = '';
    public $type = '';
    public $risks;

    protected $rules = [
        'description' => 'required|string|max:255',
        'type' => 'required|in:financial,technical',
    ];

    public function mount()
    {
        $this->loadRisks();
    }

    public function loadRisks()
    {
        $this->risks = Auth::user()->risks()->with('reporter')->get();
    }

    public function submit()
    {
        $this->validate();

        Risk::create([
            'reported_by' => Auth::id(),
            'description' => $this->description,
            'type' => $this->type,
            'status' => 'pending',
        ]);

        $this->reset(['description', 'type']);
        $this->loadRisks(); // Refresh table
    }

    public function render()
    {
        return view('livewire.staff-page');
    }
}
