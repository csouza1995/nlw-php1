<?php

namespace App\Livewire\Proposals;

use App\Actions\ArrangeProposalsPositions;
use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Support\Facades\DB;
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

        DB::transaction(function () {
            $proposal = $this->project->proposals()
                ->updateOrCreate([
                    'email' => $this->email,
                ], [
                    'hours' => $this->hours,
                ]);

            $this->refreshPositions($proposal);

            $this->dispatch('proposal::created');
        });

        $this->modal = false;
    }

    protected function refreshPositions($proposal)
    {
        $proposals = DB::select("
            select *, row_number() over (order by hours asc) as new_position
            from proposals
            where project_id = :project_id
        ", [
            'project_id' => $proposal->project_id,
        ]);

        $currentProposal = collect($proposals)
            ->firstWhere('id', $proposal->id);

        $otherProposals = collect($proposals)
            ->firstWhere('position', $currentProposal->new_position);

        if ($otherProposals) {
            $proposal->update(['position_status' => 'up']);
            Proposal::query()
                ->where('id', $otherProposals->id)
                ->update(['position_status' => 'down']);
        }

        ArrangeProposalsPositions::run($proposal->project_id);
    }

    public function render()
    {
        return view('livewire.proposals.create');
    }
}
