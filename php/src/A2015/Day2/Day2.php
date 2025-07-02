<?php

namespace Factor\Aoc\A2015\Day2;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day2 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $dataset[] = sscanf($line, '%dx%dx%d');
        }

        $this->dataset = $dataset;
    }


    public function part1(): int
    {
        $result = 0;

        foreach ($this->dataset as [$l, $w, $h]) {
            $area = [$l * $w, $w * $h, $h * $l];
            $result += array_sum(array_map(static fn($a) => 2 * $a, $area)) + min($area);
        }

        return $result;
    }

    public function part2(): int
    {
        $result = 0;

        foreach ($this->dataset as $area) {
            sort($area);
            [$l, $w, $h] = $area;
            $result += ($area[0]*2) + ($area[1]*2) + ($l*$w*$h);
        }

        return $result;
    }
}

$day = new Day2(__DIR__);
$day->run();
