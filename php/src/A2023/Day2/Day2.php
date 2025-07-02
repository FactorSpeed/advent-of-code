<?php

namespace Factor\Aoc\A2023\Day2;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day2 extends AdventOfCode
{
    public const array COLORS = [
        'red' => 12,
        'green' => 13,
        'blue' => 14,
    ];

    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file_test) as $line) {
            preg_match('/^Game (\d+): (.+)$/', $line, $sets);

            $dataset[] = [
                'number' => $sets[1],
                'sets' => array_map(static function ($set) {
                    preg_match_all('/(\d+)\s+(blue|red|green)/', $set, $matches, PREG_SET_ORDER);
                    return array_map(static fn($match) => ['number' => (int)$match[1], 'color' => $match[2]], $matches);
                }, explode(';', $sets[2]))
            ];
        }

        $this->dataset = $dataset;
    }


    public function part1(): int
    {
        $result = 0;

        $dataset = $this->dataset;

        foreach ($dataset as $game) {
            $check = true;
            foreach ($game['sets'] as $set) {
                foreach($set as $s) {
                    [$n, $max] = [$s['number'], self::COLORS[$s['color']]];
                    if ($n > $max) {
                        $check = false;
                        break;
                    }
                }
            }

            if ($check) {
                $result += $game['number'];
            }
        }

        return $result;
    }

    public function part2(): int
    {
        $result = 0;

        $dataset = $this->dataset;

        foreach ($dataset as $game) {
            $balls = ['green' => 0, 'red' => 0, 'blue' => 0];
            foreach ($game['sets'] as $set) {
                foreach($set as $s) {
                    [$n, $color] = [$s['number'], $s['color']];
                    if ($balls[$color] < $n) {
                        $balls[$color] = $n;
                    }
                }
            }

            $result += array_reduce($balls, static fn($a, $b) => $a * $b,1);
        }

        return $result;
    }
}

$day = new Day2(__DIR__);
$day->run();
