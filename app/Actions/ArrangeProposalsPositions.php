<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;

class ArrangeProposalsPositions
{
    public static function run(int $project_id)
    {
        DB::update("
                    with RankedProposals as (
                        select
                            id,
                            row_number() over (order by hours asc) as position
                        from proposals
                        where project_id = :project_id
                    )
                    update proposals
                    set position = (select position from RankedProposals where id = proposals.id)
                    where project_id = :project_id
                ", [
            'project_id' => $project_id,
        ]);
    }
}