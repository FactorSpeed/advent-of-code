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

        $this->dataset['init'] = $dataset;
        $this->dataset['solved'] = $dataset;
    }

    public function getStartPoint(): array
    {
        foreach ($this->dataset['init'] as $x => $xv) {
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
        return match ($direction) {
            Direction::N => [Direction::E, 0, 1],
            Direction::E => [Direction::S, 1, 0],
            Direction::S => [Direction::W, 0, -1],
            Direction::W => [Direction::N, -1, 0],
        };
    }

    public function getScore(): int
    {
        $result = 0;

        foreach ($this->dataset['solved'] as $xv) {
            foreach ($xv as $yv) {
                if ($yv === "X" || $yv === "^") {
                    $result++;
                }
            }
        }

        return $result;
    }

    public function loop(array &$dataset, Direction $direction, int $sx, int $sy, int $vx, int $vy, int $mx, int $my): void
    {
        while (true) {
            [$nsx, $nsy] = [$sx + $vx, $sy + $vy];

            if ($nsx < 0 || $nsy < 0 || $nsx >= $mx || $nsy >= $my) {
                break;
            }

            if ($dataset[$nsx][$nsy] === '#') {
                [$direction, $vx, $vy] = $this->rotate90($direction);
                continue;
            }

            $dataset[$nsx][$nsy] = 'X';

            [$sx, $sy] = [$nsx, $nsy];
        }
    }

    public function getDimensions(): array
    {
        return [count($this->dataset['init']), count($this->dataset['init'][0])];
    }

    public function part1(): int
    {
        [$sx, $sy] = $this->getStartPoint();
        [$direction, $vx, $vy] = $this->rotate90(Direction::W);
        [$mx, $my] = $this->getDimensions();

        $this->loop($this->dataset['solved'], $direction, $sx, $sy, $vx, $vy, $mx, $my);

        return $this->getScore();
    }

    public function loop2(array $dataset, Direction $direction, int $sx, int $sy, int $vx, int $vy, int $mx, int $my): bool
    {
        $history = [];

        while (true) {
            [$nsx, $nsy] = [$sx + $vx, $sy + $vy];

            if ($nsx < 0 || $nsy < 0 || $nsx >= $mx || $nsy >= $my) {
                return false;
            }

            if ($dataset[$nsx][$nsy] === '#') {
                [$direction, $vx, $vy] = $this->rotate90($direction);
                continue;
            }

            $dataset[$nsx][$nsy] = 'X';

            $report = implode('-', [$direction->value, $nsx, $nsy]);

            if (in_array($report, $history, true)) {
                return true;
            }

            $history[] = $report;

            [$sx, $sy] = [$nsx, $nsy];
        }
    }

    public function part2(): int
    {
        [$sx, $sy] = $this->getStartPoint();
        [$direction, $vx, $vy] = $this->rotate90(Direction::W);
        [$mx, $my] = $this->getDimensions();

        $result = 0;

        foreach ($this->dataset['solved'] as $x => $xv) {
            foreach ($xv as $y => $yv) {
                if ($yv === "X") {
                    $dataset = $this->dataset['init'];

                    $dataset[$x][$y] = '#';

                    $result += $this->loop2($dataset, $direction, $sx, $sy, $vx, $vy, $mx, $my);
                }
            }
        }

        return $result;
    }
}

$day = new Day6(__DIR__ . '/6.txt');
$day->run();
