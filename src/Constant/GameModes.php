<?php

namespace App\Constant;

final class GameModes
{
    public const MODES = [
        'fortnite' => [
            'battle_royale' => ['solo' => [], 'duo' => [], 'trio' => [], 'squad' => []],
            'zero_build_battle_royale' => ['solo' => [], 'duo' => [], 'trio' => [], 'squad' => []],
            'reload' => ['solo' => [], 'duo' => []],
            'zero_build_reload' => ['solo' => [], 'duo' => []],
            'creative' => ['boxfight' => ['1v1', '2v2', '3v3', '4v4'], 'zone_wars' => ['1v1', '2v2', '3v3', '4v4'], 'realistic' => ['1v1', '2v2', '3v3', '4v4']],
        ],
        'apex-legends' => [
            'default' => ['battle_royale' => []],
        ],
        'counter-strike-2' => [
            'default' => ['bomb_defusal' => [], 'deathmatch' => []],
        ],
        'valorant' => [
            'default' => ['plant_defuse' => [], 'deathmatch' => []],
        ],
        'rainbow-six-siege' => [
            'default' => ['bomb' => []],
        ],
        'overwatch-2' => [
            'default' => ['control' => [], 'escort' => [], 'hybrid' => [], 'push' => []],
        ],
        'fragpunk' => [
            'default' => ['shard_clash' => []],
        ],
        'marvel-rivals' => [
            'default' => ['convoy' => [], 'domination' => [], 'convergence' => []],
        ],

        'league-of-legends' => [
            'default' => ['summoners_rift' => []],
        ],
        'dota2' => [
            'default' => ['captains_mode' => [], 'all_pick' => []],
        ],

        'super-smash-bros' => [
            'default' => ['singles' => [], 'doubles' => []],
        ],
        'tekken-8' => [
            'default' => ['singles' => []],
        ],
        'teamfight-tactics' => [
            'default' => ['free_for_all' => []],
        ],
        'rocket-league' => [
            'default' => ['duel' => [], 'doubles' => [], 'standard' => []],
        ],
        'pokemon' => [
            'default' => ['vgc_2v2_double_battles' => [], 'smogon_singles' => ['OU (OverUsed)', 'Ubers', 'UU (UnderUsed)', 'RU (RarelyUsed)', 'NU (NeverUsed)', 'PU', 'LC (Little Cup)', 'Monotype', 'Balanced Hackmons', 'Anything Goes (AG)']],
        ],
    ];

    public static function getGames(): array
    {
        return array_keys(self::MODES);
    }

    public static function getCategoriesForGame(string $slug): array
    {
        return array_keys(self::MODES[$slug] ?? []);
    }

    public static function getModesForGameAndCategory(string $slug, string $category): array
    {
        return self::MODES[$slug][$category] ?? [];
    }

    public static function hasSubFormats(string $slug, string $category, string $mode): bool
    {
        return isset(self::MODES[$slug][$category][$mode]) &&
            is_array(self::MODES[$slug][$category][$mode]) &&
            !empty(self::MODES[$slug][$category][$mode]);
    }

    public static function getSubFormats(string $slug, string $category, string $mode): array
    {
        return self::MODES[$slug][$category][$mode] ?? [];
    }

    public static function getFullPathOptions(string $slug): array
    {
        $result = [];
        foreach (self::MODES[$slug] ?? [] as $category => $modes) {
            foreach ($modes as $mode => $subFormats) {
                if (!empty($subFormats)) {
                    foreach ($subFormats as $format) {
                        $result[] = [
                            'category' => $category,
                            'mode' => $mode,
                            'format' => $format,
                        ];
                    }
                } else {
                    $result[] = [
                        'category' => $category,
                        'mode' => $mode,
                        'format' => null,
                    ];
                }
            }
        }
        return $result;
    }


    public static function getAllGameModesStructured(): array
    {
        $all = [];
        foreach (self::MODES as $category => $modes) {
            foreach ($modes as $mode) {
                $all[] = $mode;
            }
        }
        return $all;
    }
    public static function getAllGameSlugs(): array
    {
        return array_keys(self::MODES);
    }
}
