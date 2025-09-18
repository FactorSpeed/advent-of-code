<?php

namespace Factor\Aoc\A2015\Day18;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day18 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $dataset[] = str_split(trim($line));
        }

        $this->dataset = $dataset;
    }

    public function display(array $set): void
    {
        [$rows, $cols] = [count($set), count($set[0])];
        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $cols; $j++) {
                echo $set[$i][$j];
            }
            echo PHP_EOL;
        }
    }

    public function state(int $i, int $j, array $set): string
    {
        $on = 0;

        foreach (Direction::cases() as $direction) {
            [$vx, $vy] = $direction->vector();
            $val = $set[$i + $vx][$j + $vy] ?? null;
            if (null === $val) {
                continue;
            }

            if ($val === '#') {
                ++$on;
            }
        }

        if ($set[$i][$j] === '#') {
            return $on === 2 || $on === 3 ? '#' : '.';
        }

        return $on === 3 ? '#' : '.';
    }

    public function countLightOn(array $set): int
    {
        $lights = 0;

        [$rows, $cols] = [count($set), count($set[0])];
        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $cols; $j++) {
                if ($set[$i][$j] === '#') {
                    ++$lights;
                }
            }
        }

        return $lights;
    }

    public function isCorner(int $rows, int $cols, int $i, int $j): bool
    {
        return
            ($i === 0 && $j === 0) ||
            ($i === 0 && $j === $cols - 1) ||
            ($i === $rows - 1 && $j === 0) ||
            ($i === $rows - 1 && $j === $cols - 1);
    }

    public function part1(): int
    {
        $data = $this->dataset;

        [$rows, $cols] = [count($data), count($data[0])];

        for ($step = 1; $step <= 100; $step++) {
            $tmp = [];
            for ($i = 0; $i < $rows; $i++) {
                $tmp[$i] = [];
                for ($j = 0; $j < $cols; $j++) {
                    $tmp[$i][$j] = $this->state($i, $j, $data);
                }
            }
            $data = $tmp;
        }

        return $this->countLightOn($data);
    }

    public function part2(): int
    {
        $data = $this->dataset;

        [$rows, $cols] = [count($data), count($data[0])];

        $data[0][0] = '#';
        $data[0][$cols - 1] = '#';
        $data[$rows - 1][0] = '#';
        $data[$rows - 1][$cols - 1] = '#';

        for ($step = 1; $step <= 100; $step++) {
            $tmp = [];
            for ($i = 0; $i < $rows; $i++) {
                $tmp[$i] = [];
                for ($j = 0; $j < $cols; $j++) {
                    if ($this->isCorner($rows, $cols, $i, $j)) {
                        $tmp[$i][$j] = '#';
                    } else {
                        $tmp[$i][$j] = $this->state($i, $j, $data);
                    }
                }
            }
            $data = $tmp;
        }

        return $this->countLightOn($data);
    }
}

$day = new Day18(__DIR__);
$day->run();
