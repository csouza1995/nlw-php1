<?php

namespace App\Livewire\Proposals;

use App\Models\Project;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Create extends Component
{
    #[Modelable]
    public bool $modal;

    public Project $project;

    public string $email = '';

    public int $hours = 0;

    public bool $agree = false;

    protected function validationAttributes()
    {
        return [
            'email' => 'Email',
            'hours' => 'Hours',
        ];
    }

    protected function rules()
    {
        return [
            'email' => ['required', 'email'],
            'hours' => ['required', 'integer', 'min:1'],
        ];
    }

    public function save()
    {
        if (!$this->agree) {
            $this->addError('agree', __('You must agree to the terms.'));
            return;
        }
        
        $this->validate();

        $this->project->proposals()
            ->create([
                'email' => $this->email,
                'hours' => $this->hours,
            ]);

        $this->modal = false;

        $this->dispatch('proposal::created');
    }

    public function render()
    {
        return view('livewire.proposals.create');
    }
}
