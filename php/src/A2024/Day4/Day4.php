<?php

namespace Factor\Aoc\A2024\Day4;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day4 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $dataset[] = str_split(str_replace("\n", '', $line));
        }

        $this->dataset = $dataset;
    }

    public function part1(): int
    {
        $result = 0;

        for ($x = 0; $x < count($this->dataset); $x++) {
            for ($y = 0; $y < count($this->dataset[$x]); $y++) {
                if ($this->dataset[$x][$y] !== 'X') {
                    continue;
                }

                foreach (Direction::cases() as $case) {
                    if ($this->process($x, $y, $case)) {
                        $result++;
                    }
                }
            }
        }

        return $result;
    }

    public function part2(): int
    {
        $result = 0;

        for ($x = 0; $x < count($this->dataset); $x++) {
            for ($y = 0; $y < count($this->dataset[$x]); $y++) {
                if ($this->dataset[$x][$y] !== 'A') {
                    continue;
                }

                $a = $this->dataset[$x - 1][$y - 1] ?? '';
                $b = $this->dataset[$x - 1][$y + 1] ?? '';
                $c = $this->dataset[$x][$y];
                $d = $this->dataset[$x + 1][$y - 1] ?? '';
                $e = $this->dataset[$x + 1][$y + 1] ?? '';

                if (
                    ($a . $c . $e === 'MAS' || $e . $c . $a === 'MAS') &&
                    ($b . $c . $d === 'MAS' || $d . $c . $b === 'MAS')
                ) {
                    $result++;
                }
            }
        }

        return $result;
    }

    public function process(int $x, int $y, Direction $direction): bool
    {
        [$vx, $vy] = match ($direction) {
            Direction::N => [0, -1],
            Direction::NE => [1, -1],
            Direction::E => [1, 0],
            Direction::SE => [1, 1],
            Direction::S => [0, 1],
            Direction::SW => [-1, 1],
            Direction::W => [-1, 0],
            Direction::NW => [-1, -1],
        };

        $move = 0;
        $xmas = '';

        while ($move < 4) {
            $xmas .= $this->dataset[$x + ($move * $vx)][$y + ($move * $vy)] ?? '';
            $move++;
        }

        return $xmas === 'XMAS';
    }
}

$day = new Day4(__DIR__ . '/4.txt');
$day->run();