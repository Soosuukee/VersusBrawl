<?php

namespace App\Constant;

final class GameModes
{
    // Tableau associatif : chaque jeu => tableau de modes
    public const MODES = [
        'apex-legends' => [
            'Battle Royale'
        ],
        'counter-strike-2' => [
            'Bomb Defusal',
            'Deathmatch',
        ],
        'dota2' => [
            "Captains Mode",
            "All Pick",
        ],
        'fortnite' => [
            'Battle Royale' => [
                'Solo',
                'Duo',
                'Trio',
                'Squad',
            ],
            'Zero Build Battle Royale' => [
                'Solo',
                'Duo',
                'Trio',
                'Squad',
            ],
            'Reload' => [
                'Solo',
                'Duo'
            ],
            'Zero Build Reload' => [
                'Solo',
                'Duo'
            ],
            'Creative' => [
                'Boxfight',
                'Zone Wars',
                'Realistic'
            ]
        ],
        'fragpunk' => [
            'Shard Clash',
        ],
        'league-of-legends' => [
            "Summoner\'s Rift",
        ],
        'marvel-rivals' => [
            'Convoy',
            'Domination',
            'Convergence',
        ],
        'overwatch-2' => [
            'Control',
            'Escort',
            'Hybrid',
            'Push'
        ],
        'pokemon' => [
            'VGC (2v2 Double Battles)',
            'Smogon Singles',
        ],
        'rocket-league' => [
            'Duel',
            'Doubles',
            'Standard',
        ],
        'super-smash-bros' => [
            'Singles',
            'Doubles',
        ],
        'teamfight-tactics' => [
            'Free For All',
        ],
        'rainbow-six-siege' => [
            'Bomb',
        ],
        'valorant' => [
            'Plant/Defuse',
            'Deathmatch',
        ],
        'tekken-8' => [
            'Singles',
        ],
        'street-fighter-6' => [
            'Singles',
        ],
        'pubg' => [
            'Battle Royale' => [
                'Solo',
                'Squad'
            ]
        ],
        'warzone' => [
            'Battle Royale' => [
                'Solo',
                'Duo',
                'Trio',
                'Squad'
            ]
        ],
        'call-of-duty' => [
            'Control',
            'Search & Destroy',
            'Hardpoint',
        ],
        'the-finals' => [
            '3v3v3v3 Tournament',
        ],
        'dragon-ball-fighterz' => [
            'Versus (1v1, 3 Characters)',
        ],
        'dragon-ball-sparking-zero' => [
            'Versus (1v1, 3 Characters)',,
        ],
        'brawlhalla' => [
            'Singles',
            'Doubles',
        ],
    ];

    public static function getModesByGame(string $gameSlug): array
    {
        return self::MODES[$gameSlug] ?? [];
    }
}
