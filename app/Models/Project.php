<?php

namespace App\Models;

use App\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    public function casts(): array
    {
        return [
            'tech_stack' => 'array',
            'ends_at' => 'datetime',
            'status' => ProjectStatus::class,
        ];
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function getOrderedProposalsAttribute()
    {
        return $this->proposals()
            ->orderByRaw('DATE(created_at) DESC')
            ->get();
    }
}
