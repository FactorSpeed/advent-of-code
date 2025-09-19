<?php

namespace Factor\Aoc\A2015\Day21;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\A2015\Itertools;
use Factor\Aoc\AdventOfCode;

class Day21 extends AdventOfCode
{
    public function getPlayers(): array
    {
        $shop = [
            Item::WEAPON => [
                new Item(Item::WEAPON, 'Dagger', 8, 4, 0),
                new Item(Item::WEAPON, 'Shortsword', 10, 5, 0),
                new Item(Item::WEAPON, 'Warhammer', 25, 6, 0),
                new Item(Item::WEAPON, 'Longsword', 40, 7, 0),
                new Item(Item::WEAPON, 'Greataxe', 74, 8, 0),
            ],
            Item::ARMOR => [
                new Item(Item::ARMOR, 'Leather', 13, 0, 1),
                new Item(Item::ARMOR, 'Chainmail', 31, 0, 2),
                new Item(Item::ARMOR, 'Splintmail', 53, 0, 3),
                new Item(Item::ARMOR, 'Bandedmail', 75, 0, 4),
                new Item(Item::ARMOR, 'Platemail', 102, 0, 5)
            ],
            Item::RING => [
                new Item(Item::RING, 'Damage +1', 25, 1, 0),
                new Item(Item::RING, 'Damage +2', 50, 2, 0),
                new Item(Item::RING, 'Damage +3', 100, 3, 0),
                new Item(Item::RING, 'Defense +1', 20, 0, 1),
                new Item(Item::RING, 'Defense +2', 40, 0, 2),
                new Item(Item::RING, 'Defense +3', 80, 0, 3)
            ]
        ];

        $players = [];

        foreach (new Itertools()->combinations($shop[Item::WEAPON]) as $weapon) {
            foreach (new Itertools()->combinations($shop[Item::ARMOR], '0-1') as $armor) {
                foreach (new Itertools()->combinations($shop[Item::RING], '0-2') as $ring) {
                    $player = new Player(100, 0, 0);

                    array_map(static fn($a) => $player->buy($a), $weapon);
                    array_map(static fn($a) => $player->buy($a), $armor);
                    array_map(static fn($a) => $player->buy($a), $ring);

                    $players[] = $player;
                }
            }
        }

        return $players;
    }

    public function part1(): int
    {
        $players = $this->getPlayers();
        $winners = [];

        /** @var \Factor\Aoc\A2015\Day21\Player $player */
        foreach ($players as $player) {
            $boss = new Boss(109, 8, 2);
            while (true) {
                $player->hit($boss);
                if ($boss->isDead()) {
                    $winners[] = $player->getGolds();
                    break;
                }
                $boss->hit($player);
                if ($player->isDead()) {
                    break;
                }
            }
        }


        return count($winners) > 0 ? min($winners) : 0;
    }

    public function part2(): int
    {
        $players = $this->getPlayers();
        $losers = [];

        /** @var \Factor\Aoc\A2015\Day21\Player $player */
        foreach ($players as $player) {
            $boss = new Boss(109, 8, 2);
            while (true) {
                $player->hit($boss);
                if ($boss->isDead()) {
                    break;
                }
                $boss->hit($player);
                if ($player->isDead()) {
                    $losers[] = $player->getGolds();
                    break;
                }
            }
        }


        return count($losers) > 0 ? max($losers) : 0;
    }
}

$day = new Day21(__DIR__);
$day->run();
