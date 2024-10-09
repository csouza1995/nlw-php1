<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public Project $project;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.projects.show');
    }
}
