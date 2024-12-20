<?php

namespace Factor\Aoc\A2024\Day12;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day12 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $dataset[] = str_split(trim(str_replace("\n", "", $line)));
        }

        $this->dataset = $dataset;
    }

    public function getArea(array $region): int
    {
        return count($region);
    }

    public function getPerimeter(array $region): int
    {
        $area = $this->getArea($region);

        $count = 0;

        for ($i = 0; $i < $area; $i++) {
            $count += 4 - $this->countNeighbor($region, $i);
        }

        return $count;
    }

    public function countNeighbor(array $region, int $index): int
    {
        $count = 0;
        foreach (Direction::cases() as $direction) {
            if (in_array($this->new_pos($direction, ...$region[$index]), $region, true)) {
                $count++;
            }
        }

        return $count;
    }

    public function traverse(array $dataset, array &$regions, array &$visited, int $i, int $j, int $row, int $col, array &$new_region = []): void
    {
        if ($visited[$i][$j] === 1) {
            return;
        }

        $l = $dataset[$i][$j];

        $new_region[] = [$i, $j];

        $visited[$i][$j] = 1;

        foreach (Direction::cases() as $case) {
            [$x, $y] = $this->new_pos($case, $i, $j);

            if ($x < 0 || $y < 0 || $x >= $row || $y >= $col) {
                continue;
            }

            if ($l === $dataset[$x][$y]) {
                $this->traverse($dataset, $regions, $visited, $x, $y, $row, $col, $new_region);
            }
        }
    }

    public function new_pos(Direction $case, int $x, int $y): array
    {
        [$dx, $dy] = $case->neighbor();
        return [$x - $dx, $y - $dy];
    }

    public function getRegions(array $dataset): array
    {
        $row = count($dataset);
        $col = count($dataset[0]);

        $visited = [];

        for ($i = 0; $i < $row; ++$i) {
            $visited[] = array_fill(0, $col, 0);
        }

        $regions = [];

        for ($i = 0; $i < $row; $i++) {
            for ($j = 0; $j < $col; $j++) {
                $new_region = [];

                $this->traverse($dataset, $regions, $visited, $i, $j, $row, $col, $new_region);

                if (!empty($new_region)) {
                    $regions[] = $new_region;
                }
            }
        }

        return $regions;
    }

    public function getCorners(array $region): int
    {
        $corners = [
            [[0, -1], [-1, -1], [-1, 0]],
            [[-1, 0], [-1, 1], [0, 1]],
            [[0, 1], [1, 1], [1, 0]],
            [[1, 0], [1, -1], [0, -1]]
        ];

        $area = $this->getArea($region);

        $count = 0;

        for ($i = 0; $i < $area; $i++) {
            $point = $region[$i];
            foreach ($corners as $corner) {
                // INNER
                if (
                    !in_array($this->new_pos2($point, $corner[0]), $region, true) &&
                    !in_array($this->new_pos2($point, $corner[1]), $region, true) &&
                    !in_array($this->new_pos2($point, $corner[2]), $region, true)
                ) {
                    $count++;
                }

                // OUTER
                if (
                    in_array($this->new_pos2($point, $corner[0]), $region, true) &&
                    !in_array($this->new_pos2($point, $corner[1]), $region, true) &&
                    in_array($this->new_pos2($point, $corner[2]), $region, true)
                ) {
                    $count++;
                }

                if (
                    !in_array($this->new_pos2($point, $corner[0]), $region, true) &&
                    in_array($this->new_pos2($point, $corner[1]), $region, true) &&
                    !in_array($this->new_pos2($point, $corner[2]), $region, true)
                ) {
                    $count++;
                }
            }
        }

        return $count;
    }

    public function new_pos2(array $region, array $corner): array
    {
        [$x, $y] = $region;
        [$dx, $dy] = $corner;
        return [$x - $dx, $y - $dy];
    }

    public function part1(): int
    {
        $dataset = $this->dataset;

        $regions = $this->getRegions($dataset);

        $result = 0;

        foreach ($regions as $region) {
            $result += $this->getArea($region) * $this->getPerimeter($region);
        }

        return $result;
    }

    public function part2(): int
    {
        $dataset = $this->dataset;

        $regions = $this->getRegions($dataset);

        $result = 0;

        foreach ($regions as $region) {
            $result += $this->getArea($region) * $this->getCorners($region);
        }

        return $result;
    }
}

$day = new Day12(__DIR__);
$day->run();
