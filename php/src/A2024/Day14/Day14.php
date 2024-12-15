<?php

namespace Factor\Aoc\A2024\Day14;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day14 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $pattern = '/p=(.*),(.*) v=(.*),(.*)/';
            preg_match_all($pattern, $line, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $dataset[] = [
                    'p' => [(int)$match[2], (int)$match[1]],
                    'v' => [(int)$match[4], (int)$match[3]]
                ];
            }
        }

        $this->dataset = $dataset;
    }

    public function getRowCol(): array
    {
        $i = 0;
        $j = 0;

        foreach ($this->dataset as $item) {
            if ($item['p'][0] > $i) {
                $i = $item['p'][0];
            }

            if ($item['p'][1] > $j) {
                $j = $item['p'][1];
            }
        }

        return [$i + 1, $j + 1];
    }

    public function part1(): int
    {
        [$row, $col] = $this->getRowCol();
        [$halfRow, $halfCol] = [floor($row / 2), floor($col / 2)];

        $set = [];
        for ($i = 0; $i < $row; $i++) {
            $set[] = array_fill(0, $col, 0);
        }

        foreach ($this->dataset as $dataset) {
            [$nx, $ny] = $dataset['p'];
            [$vx, $vy] = $dataset['v'];

            for ($k = 0; $k < 100; $k++) {
                [$ny, $nx] = [$ny + $vy, $nx + $vx];

                if ($nx < 0) {
                    $nx = $row + $nx;
                }

                if ($nx >= $row) {
                    $nx -= $row;
                }

                if ($ny < 0) {
                    $ny = $col + $ny;
                }

                if ($ny >= $col) {
                    $ny -= $col;
                }
            }

            $set[$nx][$ny] += 1;
        }

        $result = ['nw' => 0, 'ne' => 0, 'sw' => 0, 'se' => 0];

        for ($i = 0; $i < $row; $i++) {
            for ($j = 0; $j < $col; $j++) {
                if ($i === $halfRow || $j === $halfCol || $set[$i][$j] === 0) {
                    continue;
                }

                // nw
                if ($i < $halfRow && $j < $halfCol) {
                    $result['nw'] += $set[$i][$j];
                    continue;
                }

                // ne
                if ($i < $halfRow && $j > $halfCol) {
                    $result['ne'] += $set[$i][$j];
                    continue;
                }

                // sw
                if ($i > $halfRow && $j < $halfCol) {
                    $result['sw'] += $set[$i][$j];
                    continue;
                }

                // se
                if ($i > $halfRow && $j > $halfCol) {
                    $result['se'] += $set[$i][$j];
                }
            }
        }

        return $result['nw'] * $result['ne'] * $result['sw'] * $result['se'];
    }

    public function part2(): int
    {
        return 0;
    }
}

$day = new Day14(__DIR__);
$day->run();
