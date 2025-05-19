<?php

namespace App\Enum;

final class GameModes
{
    // Tableau associatif : chaque jeu => tableau de modes
    public const MODES = [
        'apex-legends' => [
            'Battle Royale'
        ],
        'counter-strike-2' => [
            '5v5 Competitive',
            'Deathmatch',
        ],
        'dota2' => [
            "5v5",
        ],
        'fortnite' => [
            'Battle Royale Solo',
            'Battle Royale Duo',
            'Battle Royale Trio',
            'Battle Royale Squad',
            'Zero Build',
            'Boxfight',
            'Zone Wars',
        ],
        'fragpunk' => [
            'Competitive',
            'Deathmatch',
        ],
        'league-of-legends' => [
            "5v5 Summoner's Rift",
            'Clash Tournament',
        ],
        'marvel-rivals' => [
            'Standard 6v6',
        ],
        'overwatch-2' => [
            'Role Queue 5v5',
            'Open Queue',
        ],
        'pokemon' => [
            'VGC (2v2 Double Battles)',
            'Smogon Singles',
        ],
        'rocket-league' => [
            '1v1 Duel',
            '2v2 Doubles',
            '3v3 Standard',
        ],
        'super-smash-bros' => [
            '1v1 Singles',
            '2v2 Doubles',
            'Crews',
        ],
        'teamfight-tactics' => [
            'Standard Lobby',
        ],
        'rainbow-six-siege' => [
            'Bomb 5v5',
        ],
        'valorant' => [
            '5v5 Competitive',
            'Deathmatch',
        ],
        'tekken-8' => [
            '1v1 Singles',
        ],
        'street-fighter-6' => [
            '1v1 Singles',
        ],
        'pubg' => [
            'Squad Battle Royale',
            'Solo Battle Royale',
        ],
        'warzone' => [
            'Battle Royale',
        ],
        'call-of-duty' => [
            'Multiplayer (6v6)',
            'Search & Destroy',
            'Hardpoint',
        ],
        'the-finals' => [
            '3v3v3v3 Tournament',
        ],
        'dragon-ball-fighterz' => [
            '1v1 Singles',
            '3v3 Teams',
        ],
        'dragon-ball-sparking-zero' => [
            'Standard',
        ],
        'brawlhalla' => [
            '1v1 Singles',
            '2v2 Doubles',
        ],
    ];

    public static function getModesByGame(string $gameSlug): array
    {
        return self::MODES[$gameSlug] ?? [];
    }
}
