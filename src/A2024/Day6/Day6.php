<?php

namespace Factor\Aoc\A2024\Day6;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day6 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $dataset[] = str_split(trim($line));
        }

        $this->dataset = $dataset;
    }

    public function getStartPoint(): array
    {
        foreach ($this->dataset as $x => $xv) {
            foreach ($xv as $y => $yv) {
                if ($yv === "^") {
                    return [$x, $y];
                }
            }
        }

        return [null, null];
    }

    public function rotate90(Direction $direction): array
    {
        $newDirection = match ($direction) {
            Direction::N => Direction::E,
            Direction::E => Direction::S,
            Direction::S => Direction::W,
            Direction::W => Direction::N,
        };

        return match ($newDirection) {
            Direction::N => [Direction::N, -1, 0],
            Direction::E => [Direction::E, 0, 1],
            Direction::S => [Direction::S, 1, 0],
            Direction::W => [Direction::W, 0, -1],
        };
    }

    public function getScore(array $dataset): int
    {
        $result = 0;

        foreach ($dataset as $xv) {
            foreach ($xv as $yv) {
                if ($yv === "X") {
                    $result++;
                }
            }
        }

        return $result;
    }

    public function part1(): int
    {
        [$sx, $sy] = $this->getStartPoint();

        [$direction, $vx, $vy] = $this->rotate90(Direction::W);

        $dataset = $this->dataset;

        $dataset[$sx][$sy] = 'X';

        while (true) {
            if (!isset($dataset[$sx + $vx][$sy + $vy])) {
                break;
            }

            if ($dataset[$sx + $vx][$sy + $vy] === '#') {
                [$direction, $vx, $vy] = $this->rotate90($direction);
            } else {
                [$sx, $sy] = [$sx + $vx, $sy + $vy];
                $dataset[$sx][$sy] = 'X';
            }
        }

        return $this->getScore($dataset);
    }

    public function part2(): int
    {
        return 0;
    }
}

$day = new Day6(__DIR__ . '/6.txt');
$day->run();
