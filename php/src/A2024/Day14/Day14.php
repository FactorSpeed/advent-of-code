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
                [$nx, $ny] = [$nx + $vx, $ny + $vy];

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
        $data = $this->dataset;

        [$row, $col] = $this->getRowCol();

        for ($k = 1; $k < 10_000; $k++) {
            $set = [];
            $chars = ',';
            foreach ($data as $d => $dataset) {
                [$nx, $ny] = $dataset['p'];
                [$vx, $vy] = $dataset['v'];

                [$nx, $ny] = [$nx + $vx, $ny + $vy];

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

                $data[$d]['p'] = [$nx, $ny];
                $set[] = [$nx, $ny];
                $chars .= $nx . '|' . $ny . ',';
            }

            if($this->countNeighbors($set, $chars) * 100 / count($set) > 60) {
                $d = [];
                for ($i = 0; $i < $row; $i++) {
                    $d[] = array_fill(0, $col, '.');
                }

                foreach ($set as $s) {
                    $d[$s[0]][$s[1]] = '#';
                }

                foreach ($d as $s) {
                    echo implode('', $s) . PHP_EOL;
                }

                return $k;
            }
        }

        return $k;
    }

    public function countNeighbors(array $set, string $chars): int
    {
        $points = [
            [0, -1],
            [1, 0],
            [0, 1],
            [-1, 0]
        ];

        $average = 0;

        foreach ($set as $s) {
            [$nx, $ny] = $s;

            foreach ($points as $point) {
                [$vx, $vy] = $point;

                $t = ',' . ($nx + $vx) . '|' . ($ny + $vy) . ',';

                if (str_contains($chars, $t)) {
                    $average++;
                }
            }
        }

        return $average;
    }
}

$day = new Day14(__DIR__);
$day->run();
