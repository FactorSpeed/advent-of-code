<?php

namespace Factor\Aoc\A2015\Day3;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day3 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $dataset = str_split(trim($line));
        }

        $this->dataset = $dataset;
    }

    public function vector($move): array
    {
        return match ($move) {
            '^' => [-1, 0],
            'v' => [1, 0],
            '<' => [0, -1],
            '>' => [0, 1],
        };
    }


    public function part1(): int
    {
        $data = $this->dataset;

        $x = 0;
        $y = 0;
        $houses = ['0,0' => 1];

        foreach ($data as $move) {
            [$dx, $dy] = $this->vector($move);
            $x += $dx;
            $y += $dy;

            $key = "$x,$y";
            $houses[$key] = ($houses[$key] ?? 0) + 1;
        }

        return count($houses);
    }

    public function part2(): int
    {
        $data = $this->dataset;

        $positions = [
            'santa' => ['x' => 0, 'y' => 0],
            'robot' => ['x' => 0, 'y' => 0],
        ];

        $houses = ['0,0' => 2];

        foreach ($data as $index => $move) {
            [$dx, $dy] = $this->vector($move);
            $mover = $index % 2 === 0 ? 'santa' : 'robot';

            $positions[$mover]['x'] += $dx;
            $positions[$mover]['y'] += $dy;

            $x = $positions[$mover]['x'];
            $y = $positions[$mover]['y'];
            $key = "$x,$y";

            $houses[$key] = ($houses[$key] ?? 0) + 1;
        }

        return count($houses);
    }
}

$day = new Day3(__DIR__);
$day->run();
