<?php

namespace Factor\Aoc\A2015\Day6;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day6 extends AdventOfCode
{
    public const int GRID_WIDTH = 1000;
    public const int GRID_HEIGH = 1000;

    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            preg_match('/(turn off|turn on|toggle) (\d+),(\d+) through (\d+),(\d+)/', trim($line), $matches);
            array_shift($matches);
            $dataset[] = array_map(static fn($a) => ctype_digit($a) ? (int)$a : $a, array_values($matches));
        }

        $this->dataset = $dataset;
    }

    public function part1(): int
    {
        $result = 0;

        $lights = array_fill(0, self::GRID_WIDTH, array_fill(0, self::GRID_HEIGH, 0));

        foreach ($this->dataset as $command) {
            $instruction = $command[0];
            for ($i = $command[1]; $i <= $command[3]; $i++) {
                for ($j = $command[2]; $j <= $command[4]; $j++) {
                    if ($instruction === 'turn on') {
                        $lights[$i][$j] = 1;
                    } elseif ($instruction === 'turn off') {
                        $lights[$i][$j] = 0;
                    } else {
                        $lights[$i][$j] = $lights[$i][$j] === 0 ? 1 : 0;
                    }
                }
            }
        }

        foreach ($lights as $row) {
            foreach ($row as $light) {
                $result += $light;
            }
        }

        return $result;
    }

    public function part2(): int
    {
        $result = 0;

        $lights = array_fill(0, self::GRID_WIDTH, array_fill(0, self::GRID_HEIGH, 0));

        foreach ($this->dataset as $command) {
            $instruction = $command[0];
            for ($i = $command[1]; $i <= $command[3]; $i++) {
                for ($j = $command[2]; $j <= $command[4]; $j++) {
                    if ($instruction === 'turn on') {
                        $lights[$i][$j] += 1;
                    } elseif ($instruction === 'turn off') {
                        $lights[$i][$j] -= 1;
                        if ($lights[$i][$j] < 0) {
                            $lights[$i][$j] = 0;
                        }
                    } else {
                        $lights[$i][$j] += 2;
                    }
                }
            }
        }

        foreach ($lights as $row) {
            foreach ($row as $light) {
                $result += $light;
            }
        }

        return $result;
    }
}

$day = new Day6(__DIR__);
$day->run();
