<?php

namespace App\Traits;

trait GameMetadataTrait
{
    public function isGameAlwaysTeamBased(string $slug): bool
    {
        return in_array($slug, [
            'overwatch-2',
            'league-of-legends',
            'dota-2',
            'fragpunk',
            'marvel-rivals',
            'tom-clancy-s-rainbow-six-siege',
        ]);
    }
}
