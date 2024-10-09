<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Attributes\Computed;
use Livewire\Component;
use stdClass;

class Timer extends Component
{
    public Project $project;

    public stdClass $timer;

    public function setTimer()
    {
        $diff = now()->diff($this->project->ends_at);

        $this->timer = new stdClass();
        $this->timer->days = $diff->d < 0 ? 0 : $diff->d;
        $this->timer->hours = $diff->h < 10 ? '0' . $diff->h : $diff->h;
        $this->timer->minutes = $diff->i < 10 ? '0' . $diff->i : $diff->i;
        $this->timer->seconds = $diff->s < 10 ? '0' . $diff->s : $diff->s;
    }

    public function render()
    {
        $this->setTimer();
        return view('livewire.projects.timer');
    }
}
